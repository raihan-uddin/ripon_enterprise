<?php
Yii::import('zii.widgets.grid.CDataColumn');

class EmployeeDropdown extends CDataColumn
{
    public $model;
    public $fieldName;

    public function init()
    {
        $ajaxUpdate = $this->grid->afterAjaxUpdate;
        $this->grid->afterAjaxUpdate = "function(id,data){'.$ajaxUpdate.' 
                $('#" . get_class($this->model) . "_" . $this->fieldName . "').select2({placeholder:' ', allowClear: true});
        }";
    }

    /**
     * Renders the filter cell.
     */
    public function renderFilterCell()
    {
        echo '<td><div class="filter-container">';
        $deviceTypes = Employees::employeeDropdownList();
        $deviceTypes[''] = ''; // Translate::t('globals', '-- all --');
        asort($deviceTypes);
        $this->filter = $deviceTypes;
        $model = $this->model;
        $field = $this->fieldName;
        if (empty($model->$field))
            echo CHtml::dropDownList(get_class($this->model) . '[' . $this->fieldName . ']', $this->fieldName, $deviceTypes);
        else
            echo CHtml::dropDownList(get_class($this->model) . '[' . $this->fieldName . ']', $this->fieldName, $deviceTypes, array(
                'options' => array(
                    $model->$field => array(
                        'selected' => true
                    )
                )
            ));
        Yii::app()->controller->widget('ext.select2.ESelect2', array(
            'selector' => '#' . get_class($this->model) . '_' . $this->fieldName,
            'data' => $deviceTypes,
            'options' => array(
                'placeholder' => ' ',
                'allowClear' => true
            ),
            'htmlOptions' => array(
                'minimumInputLength' => 2,
                'style' => 'width:100%'
            )
        ));
        echo '</div></td>';
    }
}

?>