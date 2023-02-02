<style>
    /*#menu .actions div {*/
    /*    float: left;*/
    /*    padding: 10px;*/
    /*    background: #EEE;*/
    /*    margin-right: 2px;*/
    /*}*/

    /*#menu .actions div:hover {*/
    /*    float: left;*/
    /*    padding: 10px;*/
    /*    background: #995353;*/
    /*    color: white !important;*/
    /*    margin-right: 2px;*/
    /*    cursor: pointer;*/
    /*    font-weight: bold;*/
    /*    text-decoration: underline;*/
    /*}*/
    nav ul li{
        border: 2px solid white;
        margin: 2px;
    }
    nav ul li a{
        color: white !important;
    }
</style>
<nav class="navbar navbar-expand-md navbar-dark bg-gradient-lightblue">
    <?php $this->widget('zii.widgets.CMenu', array(
        'firstItemCssClass' => 'first',
        'lastItemCssClass' => 'last',
        'htmlOptions' => array('class' => 'navbar-nav'),
        'items' => array(
            array(
                'label' => Rights::t('core', 'Assignments'),
                'url' => array('assignment/view'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Permissions'),
                'url' => array('authItem/permissions'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Roles'),
                'url' => array('authItem/roles'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Tasks'),
                'url' => array('authItem/tasks'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Operations'),
                'url' => array('authItem/operations'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Update Permission Cache File'),
                'url' => array('authItem/generateFile'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Dashboard'),
                'url' => array('/site/dashBoard'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
            array(
                'label' => Rights::t('core', 'Logout'),
                'url' => array('/site/logout'),
                'itemOptions' => array('class' => 'nav-item d-none d-sm-inline-block'),
                'linkOptions' => array('class' => 'nav-link'),
            ),
        )
    )); ?>
</nav>
</br>
</br>