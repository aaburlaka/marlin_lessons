<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <title>
            Подготовительные задания к курсу
        </title>
        <meta name="description" content="Chartist.html">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
        <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
        <link rel="stylesheet" media="screen, print" href="css/statistics/chartist/chartist.css">
        <link rel="stylesheet" media="screen, print" href="css/miscellaneous/lightgallery/lightgallery.bundle.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
        <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
    </head>
    <body class="mod-bg-1 mod-nav-link ">
        <main id="js-page-content" role="main" class="page-content">
            <div class="col-md-6">
                <div id="panel-1" class="panel">
                    <div class="panel-hdr">
                        <h2>
                            Задание
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                            <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        </div>
                    </div>
                    <div class="panel-container show">
                        <div class="panel-content">
                           <div class="d-flex flex-wrap demo demo-h-spacing mt-3 mb-3">
<?

/*

CREATE TABLE `persons_task_7` (
  `id` INT(11) auto_increment primary key,
  `name` varchar(50),
  `surname` varchar(50),
  `short` varchar(50),
  `photo` varchar(50),
  `skill` varchar(50),
  `role` varchar(50),
  `twitter` varchar(50),
  `wrapbootstrap` varchar(50),
  `active` int(1)
)

INSERT INTO `persons_task_7` (`id`, `name`, `surname`, `short`, `photo`, `skill`, `role`, `twitter`, `wrapbootstrap`, `active`) VALUES
  (1, 'Sunny', '', 'A.', 'sunny.png', 'UI/UX Expert', 'Lead Author', '@myplaneticket', 'myorange', 1),
  (2, 'Jos', '', 'K.', 'josh.png', 'ASP.NET Developer', 'Partner & Contributor', '@atlantez', 'Walapa', 1),
  (3, 'Jovanni', 'Lo', 'L.', 'jovanni.png', 'PHP Developer', 'Partner & Contributor', '@lodev09', 'lodev09', 0),
  (4, 'Roberto', '', 'R.', 'roberto.png', 'Rails Developer', 'Partner & Contributor', '@sildur', 'sildur', 0);

*/
  $host = 'localhost';
  $base = 'marlin_lessons';
  $user = 'root';
  $pass = '';

  $sql = 'SELECT * FROM persons_task_7 ORDER BY id';

  $dbh = new PDO('mysql:host='.$host.';dbname='.$base.';', $user, $pass);
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $persons = $sth->fetchAll(PDO::FETCH_ASSOC);

  foreach ($persons as $man) {
  	if (!$man['surname'])
  		$man['surname'] = $man['short'];

?>
                            <div class="<?= ($man['active'] != true) ? 'banned ' : '' ?>rounded-pill bg-white shadow-sm p-2 border-faded mr-3 d-flex flex-row align-items-center justify-content-center flex-shrink-0">
                                <img src="img/demo/authors/<?=$man['photo']?>" alt="<?=$man['name']?> <?=$man['surname']?>" class="img-thumbnail img-responsive rounded-circle" style="width:5rem; height: 5rem;">
                                <div class="ml-2 mr-3">
                                    <h5 class="m-0">
                                        <?=$man['name']?> <?=$man['short']?> (<?=$man['skill']?>)
                                        <small class="m-0 fw-300">
                                            <?=$man['role']."\n"?>
                                        </small>
                                    </h5>
                                    <a href="https://twitter.com/<?=$man['twitter']?>" class="text-info fs-sm" target="_blank"><?=$man['twitter']?></a> -
                                    <a href="https://wrapbootstrap.com/user/<?=$man['wrapbootstrap']?>" class="text-info fs-sm" target="_blank" title="Contact <?=$man['name']?>"><i class="fal fa-envelope"></i></a>
                                </div>
                            </div>
<?
	}

?>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <script src="js/vendors.bundle.js"></script>
        <script src="js/app.bundle.js"></script>
        <script>
            // default list filter
            initApp.listFilter($('#js_default_list'), $('#js_default_list_filter'));
            // custom response message
            initApp.listFilter($('#js-list-msg'), $('#js-list-msg-filter'));
        </script>
    </body>
</html>
