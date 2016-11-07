<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サンプル <?= $app_nowtitle ?></title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- jQuery -->
    <script   src="http://code.jquery.com/jquery-3.1.1.min.js"   integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="   crossorigin="anonymous"></script>

    <!-- datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

    <!-- bootstrap -->
    <?php 
    $theme = Configure::read("themes");
    $tab = TableRegistry::get("Confs");
    $tv = $tab->get(1); // ID1がデザインテーマ
    $bscssurl = $theme[$tv->value]["url"];
    ?>
    <!-- <link rel="stylesheet" href="http://bootswatch.com/united/bootstrap.min.css" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?= $bscssurl ?>" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- moment.js -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js" integrity="sha256-4PIvl58L9q7iwjT654TQJM+C/acEyoG738iL8B8nhXg=" crossorigin="anonymous"></script> 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/locale/ja.js" integrity="sha256-OjLbCOiHSOaw+9OnTaNG5US7+rf+prL29XyB/fd05jU=" crossorigin="anonymous"></script>

    <!-- bootstrap-datetimepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css" integrity="sha256-IihK1cRp3mOP+uJ2NIWC4NK60QT0nPwLDHyh1ekT5/w=" crossorigin="anonymous" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js" integrity="sha256-I8vGZkA2jL0PptxyJBvewDVqNXcgIhcgeqi+GD/aw34=" crossorigin="anonymous"></script>

    <!-- web font -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/notosansjp.css">

    <!-- Orgbake -->
    <link rel="stylesheet" href="/orgbake/css/orgbake.css" />
    <script type="text/javascript" src="/orgbake/js/conf_datetimepicker.js"></script>
    <script type="text/javascript" src="/orgbake/js/conf_datatables.js"></script>
    <script type="text/javascript">
    // 各種初期化
    $(function() {
        initMoment();
    });
    </script> 
    <?php
    if($app_nowauth->user() != null) {
        $logo_url = "/orgbake/Tops";
        $logout_css = "";
    }  else {
        $logo_url = "#";
        $logout_css = "sr-only";
    }
    ?>
</head>
<body id="body" class="container-fluid">
    <nav class="navbar navbar-default hdn_print">
        <div class="container-fluid">
            <div class="">
                <a class="" href="<?= $logo_url ?>">
                    <span class="">
                        <h3 class="text-info">
                            <strong>サンプルシステム<br/>コメント投稿</strong>
                        </h3>
                    </span>
                </a>
                <div class="pull-right <?= $logout_css ?>">
                    <a id="btn_logout" class="btn btn-success" href="/orgbake/logout/">ログアウト</a>
                </div>
            </div>
            <?php if($app_nowauth->user() != null): ?>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                        <li><a href="/orgbake/Comments/">コメント</a></li>
                <?php if($app_nowauth->user()["role"] == "admin") : ?>
                        <li><a href="/orgbake/Users/">ユーザ</a></li>
                        <li><a href="/orgbake/Confs/">設定</a></li>
                <?php endif; ?>
            </ul>
            </div><!-- /.navbar-collapse -->
            <?php endif; // isset($now_auth) ?>
        </div><!-- /.container-fluid -->

    </nav>

    <?= $this->Flash->render() ?>
    <?= $this->Flash->render("auth") ?>

    <div id="main" class='container-fluid'>
        <h1 id='title_page'><?= $app_nowtitle ?></h1>
        <div class="row">
    <?php
        if(!isset($app_nowmenus) || count($app_nowmenus) <= 0) {
            $maincol = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
        } else {
            $sidecol = "col-xs-12 col-sm-12 col-md-3 col-lg-2";
            $maincol = "col-xs-12 col-sm-12 col-md-9 col-lg-10";
            // サイドバーの出力
            echo <<< EOM
            <div id="sidebar" class="{$sidecol} hdn_print">
                <div class="list-group">
                    <div class="list-group-item list-group-item-success">
                    メニュー
                    </div>

EOM;
            foreach($app_nowmenus as $title => $menu) {
                if(is_array($menu)) {
                    if($menu["action"] == "delete") {
                        echo $this->Form->postLink($title, 
                                                $menu,
                                                ["confirm" => "本当に削除しますか？",
                                                "class" => "list-group-item"]
                                                ); 
                    } else {
                        echo $this->Html->link($title, $menu, ["class" => "list-group-item"]);
                    }
                } else {
                    // 文字列ならそのまま出力
                    echo $menu;
                }
            }
            echo <<< EOM
                </div>
            </div> <!-- sidebar -->
EOM;
        }
    ?>
            <div id="maincontent" class="<?= $maincol ?>">
                <section class="clearfix">
                    <?= isset($app_nowsubtitle) ? "<h3 class='action_page'>{$app_nowsubtitle}</h3>" : "" ?>
                    <?= $app_topcontent ?>
                    <?= $this->fetch('content') ?>
                    <?= $app_btmcontent ?>
                </section>
            </div> <!-- #maincontent -->
        </div> <!-- .row -->
    </div> <!-- #main -->
    <footer>
    </footer>
</body>
</html>
