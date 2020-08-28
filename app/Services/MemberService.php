<?php 

namespace app\Services;

use App\Services\Base as BaseService;
use App\Models\Member;
use frame\Session;

/**
 * 	用户公共类
 */
class MemberService extends BaseService
{	
	const INFO_CACHE_TIMEOUT = 3600 *24;

	public function __construct(Member $model)
    {
        $this->baseModel = $model;
    }

	/**
	 * @method 创建用户
	 * @author Victoria
	 * @date   2020-01-12
	 * @return boolean
	 */
	public function create($data)
	{
		if (empty($data['password'])) return false;
		$data['salt'] = $this->getSalt();
		$data['password'] = password_hash($this->getPasswd($data['password'], $data['salt']), PASSWORD_DEFAULT);

		return $this->baseModel->insertGetId($data);
	}

	public function updateById($memId, $data)
	{
		if (empty($memId) || empty($data)) return false;

		if (!empty($data['password'])) {
			$data['salt'] = $this->getSalt();
			$data['password'] = password_hash($this->getPasswd($data['password'], $data['salt']), PASSWORD_DEFAULT);
		}

		return $this->baseModel->updateDataById($memId, $data);
	}

	/**
	 * @method 登陆
	 * @author Victoria
	 * @date   2020-01-11
	 * @param  string     $name    	名称或者手机号码
	 * @param  string     $password 密码
	 * @return array
	 */
	public function login($mobile, $password, $isToken = false, $isAdmin = false)
	{
		if (empty($mobile) || empty($password)) return false;

		$info = $this->getInfoByMobile($mobile);

		if (empty($info)) return false;

		if (!$info['status']) return false;

		$password = $this->getPasswd($password, $info['salt']);

		if ($this->checkPassword($password, $info['password'])) {
			$data = [
				'mem_id' => $info['mem_id'],
				'name' => $info['name'],
				'mobile' => $info['mobile'],
				'nickname' => $info['nickname'],
				'avatar' => media($info['avatar'], 'avatar', ['female'=> ($info['gender'] ?? 0) == 0 ? true : false]),
				'salt' => $info['salt'],
			];

			if ($isAdmin) {
				if (!empty($info['color_id'])) {
					$colorService = \App::make('App\Services\Admin\ColorService');
					$colorInfo = $colorService->loadData($info['color_id']);
				}
				$data['is_super'] = $info['is_super'];
				$data['color_name'] = $colorInfo['color_name'] ?? '';
				$data['color_value'] = $colorInfo['color_value'] ?? '';
			}

			return Session::set($isAdmin ? 'admin' : 'home', $data);
		}

		return false;
	}

	/**
	 * @method 检查两者密码
	 * @author Victoria
	 * @date   2020-03-22
	 * @param  string        $inPassword     输入密码
	 * @param  string        $sourcePassword 源密码
	 * @return boolean
	 */
	public function checkPassword($inPassword = '', $sourcePassword = '')
	{
		return password_verify($inPassword, $sourcePassword);
	}

	/**
	 * @method 通过用户ID生成token
	 * @author Victoria
	 * @date   2020-01-11
	 * @param  integer       $userId   
	 * @param  integer       $loginType
	 * @return array token
	 */
    public function generateToken($userId, $loginType=0)
    {
        $token = $refreshToken = null;
        $maxTrayCount = 10;
        
        $counter = 0;
        do {
            $token = Str::random(32);
        } while (Cache::get($token) && ($counter++) < $maxTrayCount);

        $counter = 0;
        do {
            $refreshToken = Str::random(32);
        } while (Cache::get($refreshToken) && ($counter++) < $maxTrayCount);

        if (empty($token) || empty($refreshToken)) return [];
        
        $expiresIn = self::constant('TOKEN_EXPIRED'); //6小时
        $refreshExpiresIn = self::constant('REFRESH_TOKEN_EXPIRED'); //15天
               
        Cache::put($token, join(':', [$userId, $loginType, $expiresIn, $refreshToken, 0, \Carbon\Carbon::now()]), $expiresIn);
        Cache::put($refreshToken, join(':', [$userId, $loginType, $refreshExpiresIn, $token, 1, \Carbon\Carbon::now()]), $refreshExpiresIn);

        // 记录用户token记录
        $this->recordToken(
            $userId,
            [$token, $expiresIn],
            [$refreshToken, $refreshExpiresIn]
        );
        
        return [
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'expires_in' => $expiresIn * 60, // 换成秒
        ];
    }

    /**
     * 记录token记录
     * @author Victoria
	 * @date   2020-01-11
	 * @param  integer       $userId   
	 * @return array token
	 */
    protected function recordToken($userId, $tokenInfo, $refreshTokenInfo)
    {
        if (empty($userId)) return ;
        
        $tokenKey = 'token:' . $userId;
        $refreshTokenKey = 'refreshToken:' . $userId;

        $tokenList = Cache::get($tokenKey);
        $refreshTokenList = Cache::get($refreshTokenKey);

        if (empty($tokenList)) $tokenList = [];
        if (empty($refreshTokenList)) $refreshTokenList = [];

        list($token, $tokenExpiresIn) = $tokenInfo;
        list($refreshToken, $refreshTokenExpiresIn) = $refreshTokenInfo;
        
        $tokenList[] = $token;
        $refreshTokenList[] = $refreshToken;

        Cache::put($tokenKey, $tokenList, $tokenExpiresIn);
        Cache::put($refreshTokenKey, $refreshTokenList, $refreshTokenExpiresIn);

        return true;
    }

	/**
	 * @method 根据名称或者手机号码获取信息
	 * @author Victoria
	 * @date   2020-01-11
	 * @return array
	 */
	public function getInfoByName($name)
	{
		if (empty($name)) return [];

		return $this->baseModel->getInfoByName($name);
	}

	/**
	 * @method 根据手机号码获取信息
	 * @author Victoria
	 * @date   2020-01-11
	 * @return array
	 */
	public function getInfoByMobile($name)
	{
		if (empty($name)) return [];

		return $this->baseModel->getInfoByMobile($name);
	}

	/**
	 * @method 检查用户存在
	 * @author Victoria
	 * @date   2020-01-11
	 * @return boolean
	 */
	public function isExistUserByName($name) 
	{
		return $this->baseModel->isExistUserByName($name);
	}

	/**
	 * @method 检查用户存在
	 * @author Victoria
	 * @date   2020-01-11
	 * @return boolean
	 */
	public function isExistUserByMobile($name) 
	{
		return $this->baseModel->isExistUserByMobile($name);
	}

	/**
     * 通过ID获取用户信息
     * 
     * @param string $userId
     * @return array 用户信息
     */
    public function getInfo($userId)
    {
        return $this->baseModel->getInfo($userId);
    }

    /**
     * @method 获取缓存数据
     * @author Victoria
     * @date   2020-01-12
     * @param  integer      $userId 
     * @return array
     */
    public function getInfoCache($userId)
    {
        $cacheKey = $this->getInfoCacheKey($userId);
        $info = Redis()->get($cacheKey);
        if (!empty($info)) {
            return $info;
        } else {
            $info = $this->getInfo($userId);
            if (!empty($info)) {
            	if (empty($info['avatar'])) {
            		$info['avatar'] = $this->getDefaultAvatar($userId);
            	} else {
            		$info['avatar'] = media($info['avatar']);
            	}
            }
            Redis()->set($cacheKey, $info, self::INFO_CACHE_TIMEOUT);

            return $info;
        }
    }

    public function getDefaultAvatar($userId)
    {
    	if (substr($userId, 0, 1) == 5)
    		return siteUrl('image/computer/admin_login_bg.png');
    	else
    		return siteUrl('image/computer/male.jpg');
    }

    /**
     * @method 缓存key
     * @author Victoria
     * @date   2020-01-12
     * @param  string      $userId 
     * @return string cachekey
     */
    public function getInfoCacheKey($userId)
    {
        return 'MEMBER_INFO_CACHE_' . $userId;
    }

    /**
     * @method 清除缓存
     * @author Victoria
     * @date   2020-01-12
     * @param  integer      $userId 
     * @return boolean
     */
    public function clearCacheKey($userId)
    {
        $cacheKey = $this->getInfoCacheKey($userId);
        $info = $this->getInfo($userId);
        return Cache::foget($cacheKey);
    }

    public function getTotal($data) 
    {
    	if (!empty($data['keyword'])) {
    		$this->baseModel->where('name', 'like', '%'.$data['keyword'].'%')
    						->orWhere('mobile', 'like', '%'.$data['keyword'].'%');
    	}
    	return $this->baseModel->count();
    }

    /**
     * @method 获取用户列表
     * @author Victoria
     * @date   2020-01-12
     * @return array list
     */
    public function getList($data, $page = 1, $size = 20)
    {

    	if (!empty($data['keyword'])) {
    		$this->baseModel->where('name', 'like', '%'.$data['keyword'].'%')
    						->orWhere('mobile', 'like', '%'.$data['keyword'].'%');
    	}

		$field = [
			'mem_id', 
			'nickname', 
			'name',
			'mobile',
			'email',
			'avatar',
			'is_super',
			'status',
			'create_at',
			'login_at',
		];
		$list = $this->baseModel->select($field)
								->offset(($page - 1) * $size)
			                    ->limit($size)
			                    ->get();
			                  
		if (!empty($list)) {
			foreach ($list as $key => $value) {
				if (empty($value['avatar'])) {
            		$value['avatar'] = $this->getDefaultAvatar($value['mem_id']);
            	} else {
            		$value['avatar'] = media($value['avatar']);
            	}
				$value['create_at'] = date('Y-m-d', $value['create_at']);
				$list[$key] = $value;
			}
		}

    	return $list;
    }
}