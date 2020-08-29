<?php $this->load('Common.baseHeader');?>
<style>
    .install{color:green;}
    .notinstall{color:red;}
</style>
<div id="divbox" class="container-fluid">
    <table class="table table-hover table-middle">
        <tr>
            <th class="col-md-1 col-1">名称</th>
            <th class="col-md-1 col-1">版本要求</th>
            <th class="col-md-6 col-6">状态</th>
        </tr>
        <tr>
            <td>PHP</td>
            <td>7.1</td>
            <td>
                <?php if(version_compare(PHP_VERSION,'7.1','>=')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>redis</td>
            <td>2.8</td>
            <td>
                <?php if(version_compare(Redis()->info()['redis_version'] ?? 0, '2.8','>=')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Mysqli</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('mysqli')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Mysqli.reconnect</td>
            <td>--</td>
            <td>
                <?php if(ini_get('mysqli.reconnect')){?>
                    <span class="install">已开启</span>
                <?php }else{?>
                    <span class="notinstall">未开启</span>
                <?php }?>
            </td>
        </tr>

        <tr>
            <td>Mysqlnd</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('mysqlnd')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Json</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('json')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Openssl</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('openssl')){
                    $openssl_sign=true;
                    ?>
                    <span class="install">已安装</span>
                <?php }else{
                    $openssl_sign=false;
                    ?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Pcre</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('pcre')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Exif</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('exif')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Curl</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('curl')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Session</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('session')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Filter</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('filter')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Iconv</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('iconv')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Reflection</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('reflection')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Mbstring</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('mbstring')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>php_zip</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('zip')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>php_xml</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('xml')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>php_gd2</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('gd')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Fileinfo</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('fileinfo')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Mailparse</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('mailparse')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
        <tr>
            <td>Imap</td>
            <td>--</td>
            <td>
                <?php if(extension_loaded('imap')){?>
                    <span class="install">已安装</span>
                <?php }else{?>
                    <span class="notinstall">未安装</span>
                <?php }?>
            </td>
        </tr>
    </table>
</div>
<?php $this->load('Common.baseFooter');?>