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
                            <h5 class="frame-heading">
                                Обычная таблица
                            </h5>
                            <div class="frame-wrap">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?
  /*
    CREATE TABLE persons_task_8 (
      id int(11) auto_increment primary key,
      name varchar(50),
      surname varchar(50),
      nickname varchar(50)
    );
  */

  $host = 'localhost';
  $base = 'marlin_lessons';
  $user = 'root';
  $pass = '';


  $sql = 'SELECT * FROM persons_task_8 ORDER BY id';

  $dbh = new PDO('mysql:host='.$host.';dbname='.$base.';', $user, $pass);
  $sth = $dbh->prepare($sql);
  $sth->execute();
  $persons = $sth->fetchAll(PDO::FETCH_ASSOC);

  foreach ($persons as $man) {
?>
                                        <tr>
                                            <th scope="row"><?=$man['id']?></th>
                                            <td><?=$man['name']?></td>
                                            <td><?=$man['surname']?></td>
                                            <td><?=$man['nickname']?></td>
                                            <td>
                                                <a href="show.php?id=<?=$man['id']?>" class="btn btn-info">Редактировать</a>
                                                <a href="edit.php?id=<?=$man['id']?>" class="btn btn-warning">Изменить</a>
                                                <a href="delete.php?id=<?=$man['id']?>" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
<?
  }

?>

                                    </tbody>
                                </table>
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
