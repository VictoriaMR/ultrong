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
}