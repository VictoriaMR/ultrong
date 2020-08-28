<?php $this->load('Common.baseHeader');?>
<div class="container-fluid">
<div class="row margin-top-15">
    <div class="col-md-12 padding-left-15">
        <dl class="cls-left-flex">
            <dt class="cls-dt-name">logo配置：</dt>
        </dl>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/computer/logo.png');?>">
                </div>
                <div class="margin-top-15">
                	<button class="btn btn-sm btn-primary modify">编辑</button>
            	</div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>主logo</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>png</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="computer/logo" data-type="png">
        </div>
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/mobile/logo.png');?>">
                </div>
                <div class="margin-top-15">
                	<button class="btn btn-sm btn-primary modify">编辑</button>
                </div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>移动端logo</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>png</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="mobile/logo" data-type="png">
        </div>
    </div>
</div>
<div class="row margin-top-15">
    <div class="col-md-12 padding-left-15">
        <dl class="cls-left-flex">
            <dt class="cls-dt-name">icon配置：</dt>
        </dl>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/favicon.ico');?>">
                </div>
                <div class="margin-top-15">
                	<button class="btn btn-sm btn-primary modify">编辑</button>
            	</div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>前台icon</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>ico</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="/favicon" data-type="ico">
        </div>
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/admin-favicon.ico');?>">
                </div>
                <div class="margin-top-15">
                	<button class="btn btn-sm btn-primary modify">编辑</button>
                </div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>后台icon</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>ico</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="/admin-favicon" data-type="icon">
        </div>
    </div>
</div>
<div class="row margin-top-15">
    <div class="col-md-12 padding-left-15">
        <dl class="cls-left-flex">
            <dt class="cls-dt-name">登录页面背景配置：</dt>
        </dl>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/computer/admin_login_bg.png');?>">
                </div>
                <div class="margin-top-15">
                	<button class="btn btn-sm btn-primary modify">编辑</button>
            	</div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>后台登录背景图</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>png</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="computer/admin_login_bg" data-type="png">
        </div>
    </div>
</div>
<div class="row margin-top-15">
    <div class="col-md-12 padding-left-15">
        <dl class="cls-left-flex">
            <dt class="cls-dt-name">错误页面：</dt>
        </dl>
    </div>
    <div class="col-md-12">
        <div class="col-md-6 flex info-item">
            <div class="col-md-6 image-item">
                <div class="logo-pic">
                    <img src="<?php echo siteUrl('image/computer/empty.png');?>">
                </div>
                <div class="margin-top-15">
                    <button class="btn btn-sm btn-primary modify">编辑</button>
                </div>
            </div>
            <div class="logo-info col-md-6">
                <h4 class="col-md-12">配置要求</h4>
                <ul class="list-unstyled">
                    <li class="col-md-12"><b>名称：  </b><span>网站错误页面</span></li>
                    <li class="col-md-12"><b>长度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>宽度：  </b><span>无限制</span></li>
                    <li class="col-md-12"><b>后缀：  </b><span>png</span></li>
                </ul>
            </div>
            <input type="file" class="hidden" data-id="computer/empty" data-type="png">
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
$(function(){
	SITEINFO.init();
});
</script>
<?php $this->load('Common.baseFooter');?>