<?php 

namespace App\Services;

use App\Services\Base as BaseService;
use App\Models\Attachment;
use App\Models\AttachmentEntity;

/**
 * 	系统文件公共类
 */
class AttachmentService extends BaseService
{	
    protected static $constantMap = [
        'base' => AttachmentEntity::class,
    ];

	public function __construct(AttachmentEntity $model, Attachment $attachModel)
    {
        $this->baseModel = $model;
        $this->attachModel = $attachModel;
    }

    public function addAttactment($data)
    {
        return $this->attachModel->insertGetId($data);
    }

    /**
	 * @method 新建系统文件记录
	 * @author Victoria
	 * @date   2020-01-15
	 * @return integer 文件记录ID attachment_id
	 */
    public function create($data)
    {
    	return $this->baseModel->insertGetId($data);
    }

    /**
     * @method 文件是否存在
     * @author Victoria
     * @date   2020-01-15
     * @param  string    $checksum 
     * @return boolean             
     */
    public function isExitsHash($checkno)
    {
    	return $this->attachModel->isExitsHash($checkno);
    }

    /**
     * @method 根据hash获取文件信息
     * @author Victoria
     * @date   2020-01-15
     * @return array
     */
    public function getAttachmentByHash($checkno)
    {
        if (empty($checkno)) return [];

    	$info = $this->attachModel->getAttachmentByHash($checkno);

        return $this->urlInfo($info);;
    }

    public function getAttachmentById($attachId)
    {
        $attachId = (int) $attachId;
        if (empty($attachId)) return [];

        $info = $this->attachModel->loadData($attachId);

        return $this->urlInfo($info);
    }

    public function getAttachmentListById($attachId)
    {
        if (empty($attachId)) return [];
        if (!is_array($attachId)) $attachId = explode(',', $attachId);

        $list = $this->attachModel->whereIn('attach_id', $attachId)
                                  ->get();
        foreach ($list as $key => $value) {
            $list[$key] = $this->urlInfo($value);
        }

        return $list;
    }

    public function getListByEntityId($entityId, $type = 0)
    {
        if (empty($entityId)) return [];
        if (!is_array($entityId)) $entityId = [$entityId];

        $list = $this->baseModel->whereIn('entity_id', $entityId)
                                ->where(!empty($type) ? ['type'=>(int)$type] : [])
                                ->get();
        if (empty($list)) return [];

        $attachIdArr = array_unique(array_column($list, 'attach_id'));

        $infoArr = $this->attachModel->whereIn('attach_id', $attachIdArr)->get();
        $infoArr = array_column($infoArr, null, 'attach_id');
        foreach ($infoArr as $key => $value) {
            $infoArr[$key] = $this->urlInfo($value);
        }

        foreach ($list as $key => $value) {
            $list[$key] = array_merge($value, $infoArr[$value['attach_id']] ?? []);
        }

        return $list;
    }

    protected function urlInfo($info)
    {
        if (!empty($info)) {
            $info['url'] = Env('APP_DOMAIN').'file_center/'.$info['path'].'/'.$info['name'].'.'.$info['type'];
        }

        return $info;
    }

    public function getListByType($type = 0)
    {
        $list = $this->baseModel->getListByType($type);
    }

    public function getListByTypeOne($type = 0) 
    {
        $info = $this->baseModel->getListByTypeOne($type);

        if (empty($info)) return [];

        $file = $this->attachModel->loadData($info['attach_id']);

        $info['url'] = $this->getUrl($file['name'], $file['cate'], $file['type']);

        return $info;
    }

    protected function getUrl($name, $cate = '', $type = '', $fileType = '')
    {
        if (empty($name)) return '';

        if (!empty($fileType))
            $name = $fileType . '/' . $name;

        if (!empty($cate))
            $name = $cate . '/' . $name;

        if (!empty($type))
            $name .= '.' . $type;

        return Env('APP_DOMAIN').'file_center/'. $name;
    }

    public function updateData($entityId, $type, $attachId = [])
    {
        $entityId = (int) $entityId;
        $type = (int) $type;
        if (empty($entityId) || empty($type)) return false;

        $result = $this->baseModel->where('entity_id', $entityId)
                          ->where('type', $type)
                          ->delete();

        if (!empty($attachId)){
            if (!is_array($attachId)) $attachId = [$attachId];
            $insert = [];
            foreach ($attachId as $key => $value) {
                $insert[] = [
                    'entity_id' => $entityId,
                    'type' => $type,
                    'attach_id' => $value,
                    'sort' => $key,
                ];

                return $this->baseModel->insert($insert);
            }
        }

        return $result;
    }

    public function getFileList($type, $page, $size)
    {
        $data = $this->baseModel->where('type', (int) $type)
                                ->value('attach_id');

        $total = count($data);
        if ($total > 0) {
            $list = $this->attachModel->whereIn('attach_id', $data)
                                      ->offset(($page - 1) * $size)
                                      ->limit($size)
                                      ->get();
            foreach ($list as $key => $value) {
                $list[$key] = $this->urlInfo($value);
            }
        }

        return $this->getPaginationList($total, $list ?? [], $page, $size);
    }

    public function addNotExist($entityId, $type, $attachId)
    {
        if (empty($entityId) || empty($type) || empty($attachId)) return false;
        if (!is_array($attachId)) $attachId = explode(',', $attachId);

        $hasIdArr = $this->baseModel->where('entity_id', $entityId)
                                    ->where('type', $type)
                                    ->value('attach_id');

        $diff = array_diff($attachId, $hasIdArr);

        if (!empty($diff)) {
            $insert = [];
            foreach ($diff as $key => $value) {
                $insert[] = [
                    'entity_id' => $entityId,
                    'type' => $type,
                    'attach_id' => $value,
                ];
            }
            $this->baseModel->insert($insert);
        }

        return true;
    }
}