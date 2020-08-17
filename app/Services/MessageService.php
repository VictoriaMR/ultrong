<?php

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Message;
use App\Models\MessageGroup;
use App\Models\MessageMember;

class MessageService extends BaseService
{
	public function __construct(Message $model, MessageGroup $group, MessageMember $member)
    {
        $this->baseModel = $model;
        $this->groupModel = $group;
        $this->memberModel = $member;
    }

    /**
     * @method 发送消息用户对用户(私聊时调用)
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return [type]     [description]
     */
    public function sendMessage($from, $to, $content, $type=0)
    {
    	$from = (int) $from;
    	if (empty($from) || empty($to) || empty($content)) return false;
    	$groupKey = $this->createGroup($from, $type, $to);
    	if ($groupKey === false) return false;

    	return $this->sendMessageByKey($groupKey, $content, $from);
    }

    /**
     * @method 发送消息 (已有聊天组直接发送, 有群组key时调用)
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return boolean
     */
    public function sendMessageByKey($groupKey, $content, $userId)
    {
    	if (empty($groupKey) || empty($content) || empty($userId)) return false;

    	//组内成员不存在则失败
    	if (!$this->isExistGroup($groupKey)) return false;
    	if (!$this->isExistMember($groupKey, $userId)) return false;

    	//消息数据
    	$insert = [
    		'group_key' => $groupKey,
    		'user_id' => $userId,
    		'content' => substr(trim($content), 0, 250),
    		'create_at' => time(),
    	];
    	$result = $this->baseModel->insert($insert);
    	if ($result) {
    		$this->updateReadCount($groupKey, $userId);
    	}
    	return $result;
    }

    /**
     * @method 更新未读消息数
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return boolean
     */
    protected function updateReadCount($groupKey, $sendUser)
    {
    	if (empty($groupKey) || empty($sendUser)) return false;
    	//消息组消息数
    	$this->groupModel->where('group_key', $groupKey)->increment('message_count');
    	//同组其他人员未读消息数
    	$this->memberModel->where('group_key', $groupKey)->where('user_id', '<>', (int) $sendUser)->increment('unread');
    	return true;
    }

    /**
     * @method 加入群组
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return boolean
     */
    public function joinInGroup($groupKey, $userId)
    {
    	$userId = (int) $userId;
    	if (empty($groupKey) || empty($userId)) return false;
    	//用户组是否存在
    	if (!$this->isExistGroup($groupKey)) return false;

    	//组用户是否存在
    	if ($this->isExistGroup($groupKey, $userId)) return true;
    	$insert = [
			'group_key' => $key,
			'user_id' => $userId,
			'create_at' => time(),
		];
		return $this->memberModel->insert($insert);
    }

    /**
     * @method 创建群组(创建群聊是调用)
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return false|string
     */
    public function createGroup($userId, $type = 1, $toUser = 0)
    {
    	$groupKey = $this->createGroupKey($userId, $toUser, $type);
    	if ($this->isExistGroup($groupKey)) return $groupKey;
    	$insert = [
			'group_key' => $groupKey,
			'user_id' => $userId,
			'type' => (int) $type,
			'create_at' => time(),
		];
		$result = $this->groupModel->insert($insert);
		//群组加人员
		$insert = [
			'group_key' => $groupKey,
			'user_id' => $userId,
			'create_at' => time(),
		];
		if (!empty($toUser)) {
			$insert = [$insert];
			$insert[] = [
				'group_key' => $groupKey,
				'user_id' => $toUser,
				'create_at' => time(),
			];
		}
		$result = $this->memberModel->insert($insert);
        if (empty($type) && substr($toUser, 0, 1) == 5) {
            // 发送初始化聊天术语
            $content = '您好, 欢迎您的咨询, 请问有什么需要帮助的吗';
            $this->sendMessageByKey($groupKey, dist($content), $toUser);
        }
		if (!$result) return false;
		return $groupKey;
    }

    /**
     * @method 获取消息组key
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return 32位string
     */
    protected function createGroupKey($from, $to=0, $type=0)
    {
    	$array = [$from, $to];
    	sort($array);
    	$key = implode('_', $array).'_'.$type;
    	if ($type == 1) {
    		$key .= '_'.$this->getSalt(8).'_'.time();
    	}
    	return md5($key);
    }

    /**
     * @method 群组是否存在
     * @author LiaoMingRong
     * @date   2020-08-14
     * @return boolean
     */
    protected function isExistGroup($key)
    {
    	if (empty($key)) return false;

    	return $this->groupModel->where('group_key', $key)->count() > 0;
    }

    protected function isExistMember($key, $userId)
    {
    	$userId = (int) $userId;
    	if (empty($key) || empty($userId)) return false;

    	return $this->memberModel->where('group_key', $key)->where('user_id', $userId)->count() > 0;
    }

    public function getListByGroupkey($groupKey, $userId, $lastId = 0)
    {
        if (empty($groupKey) || empty($userId)) return [];
        if (!$this->isExistMember($groupKey, $userId)) return [];

        $list = $this->baseModel->where('group_key', $groupKey)
                                ->where('message_id', '>', (int) $lastId)
                                ->orderBy('create_at', 'asc')
                                ->get();

        if (empty($list)) return $list;

        $memberService = \App::make('App/Services/MemberService');
        $adminMemberService = \App::make('App/Services/Admin/MemberService');
        $lastTime = $this->baseModel->loadData($lastId);
        $lastTime = $lastTime['create_at'] ?? 0;
        foreach ($list as $key => $value) {
            $info = [];
            if (!empty($value['user_id'])) {
                if (substr($value['user_id'], 0, 1) == 5) {
                    $info = $adminMemberService->getInfoCache($value['user_id']);
                } else {
                    $info = $memberService->getInfoCache($value['user_id']);
                }
            }
            $value['user_avatar'] = !empty($info['avatar']) ? $info['avatar'] : $memberService->getDefaultAvatar($value['user_id']);
            $value['is_self'] = $value['user_id'] == $userId ? 1 : 0;
            if ($value['create_at'] - $lastTime > 300) {
                $lastTime = $value['create_at'];
                $value['create_at'] = date('Y-m-d H:i', $value['create_at']);
            } else {
                $value['create_at'] = '';
            }

            $list[$key] = $value;
        }

        return $list;
    }
}