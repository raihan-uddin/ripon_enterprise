<?php
$prodModel = ProdModels::model()->findByPk($model->fg_model_id);
$imageWithUrl1 = $prodModel->image != "" ? Yii::app()->baseUrl . "/uploads/products/$prodModel->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";

$this->widget('application.components.BreadCrumb', array(
    'crumbs' => array(
        array('name' => 'Software', 'url' => array('')),
        array('name' => 'Software Settings', 'url' => array('admin')),
        array('name' => 'FG Config (BOM)', 'url' => array('admin')),
        array('name' => 'View BOM: ' . $prodModel->model_name,
        ),
//    'delimiter' => ' &rarr; ',
    )));
?>

<div style="width: 100%;">
    <a class="btn btn-danger text-right mb-2" type="button"
       href="<?= Yii::app()->baseUrl . '/index.php/production/bom/admin' ?>"><i class="fa fa-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-sm-12 col-md-2">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="<?= $imageWithUrl1 ?>" alt="<?= $prodModel->model_name ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $prodModel->model_name ?></h5>
                <p class="card-text"><?= $prodModel->code ?></p>
                <!--                    <a href="#" class="btn btn-primary">Go somewhere</a>-->
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-10">
        <table class="table table-bordered table-hover table-valign-middle">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Material Name</th>
                <th scope="col">Material Code</th>
                <th scope="col">Qty</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $criteria = new CDbCriteria();
            $criteria->select = "t.*, pm.model_name, pm.code, pm.image";
            $criteria->join = " INNER JOIN prod_models pm on t.model_id = pm.id ";
            $criteria->addColumnCondition(['bom_id' => $model->id]);
            $criteria->order = 'pm.model_name';
            $bom2 = BomDetails::model()->findAll($criteria);
            $sl = 1;
            foreach ($bom2 as $b) {
                $imageWithUrl = $b->image != "" ? Yii::app()->baseUrl . "/uploads/products/$b->image" : Yii::app()->theme->baseUrl . "/images/no-image.jpg";
                ?>
                <tr>
                    <th scope="row"><?= $sl++ ?></th>
                    <td class="w-25">
                        <img src="<?= $imageWithUrl ?>"
                             class="img-fluid img-thumbnail" style="height: 100px; width: 100px;"
                             alt="<?= $b->model_name ?>">
                    </td>
                    <td><?= $b->model_name ?></td>
                    <td><?= $b->code ?></td>
                    <td><?= $b->qty . Units::model()->nameOfThis($b->unit_id) ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
