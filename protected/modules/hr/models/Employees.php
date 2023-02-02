<?php

/**
 * This is the model class for table "employees".
 *
 * The followings are the available columns in table 'employees':
 * @property integer $id
 * @property string $full_name
 * @property string $designation_id
 * @property string $department_id
 * @property string $id_no
 * @property string $contact_no
 * @property string $email
 * @property string $address
 * @property integer $is_active
 * @property string $permanent_address
 * @property integer $gender
 * @property integer $marital_status
 * @property integer $blood_group
 * @property integer $branch_id
 * @property integer $employee_type
 * @property string $national_id_no
 * @property string $contact_no_office
 * @property string $contact_no_home
 * @property string $contact_end
 * @property string $photo
 * @property string $files
 * @property string $emp_id_no
 * @property string $tin
 * @property integer $flag
 */

class Employees extends CActiveRecord
{


    /**
     * Returns the static model of the specified AR class.
     * @return Employees the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'employees';
    }

    const ACTIVE = 1;
    const INACTIVE = 2;

    public $startDate;
    public $endDate;

    public $ah_proll_normal_id;
    public $isPercentAmount;
    public $percentAmount;
    public $percentage_of_ah_proll_normal_id;
    public $amount_adj;
    public $earn_deduct_type;
    public $start_from;
    public $end_to;
    public $lh_proll_normal_id;
    public $day;
    public $hour;
    public $p_status;
    public $date;
    public $empId;

    public $join_date;
    public $permanent_date;
    public $father_name;
    public $father_occupation;
    public $mother_name;
    public $mother_occopation;
    public $spouse_name;
    public $spouse_details;
    public $dob;
    public $bank_ac_no;
    public $bank;
    public $country_id;
    public $section_id;
    public $sub_department_id;
    public $spouse_relation;
    public $prev_info;
    public $skills;
    public $edu_info;
    public $stuff_cat_id;
    public $stuff_sub_cat_id;
    public $shift_id;
    public $religion;
    public $reference;
    public $monthly_installment;
    public $opening_balance;
    public $marrage_date;
    public $p_email;
    public $bank_name;
    public $reference_name;
    public $reference_no;
    public $pf_openning;
    public $job_res;

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('full_name', 'required'),
            array('is_active, gender, marital_status, blood_group, branch_id, employee_type, flag', 'numerical', 'integerOnly' => true),
            array('full_name, id_no, national_id_no, contact_no_office, contact_no_home, photo, files, emp_id_no', 'length', 'max' => 255),
            array('contact_no', 'length', 'max' => 20),
            array('email', 'length', 'max' => 50),
            array('tin', 'length', 'max' => 100),
            array('designation_id, department_id, address, permanent_address, contact_end', 'safe'),
            // The following rule is used by search().
            array('id, full_name, designation_id, department_id, id_no, contact_no, email, address, is_active, permanent_address, gender, marital_status, blood_group, branch_id, employee_type, national_id_no, contact_no_office, contact_no_home, contact_end, photo, files, emp_id_no, tin, flag', 'safe', 'on' => 'search'),
        );
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Member ID',
            'device_id' => 'Device ID',
            'emp_id_no' => 'Member ID ',
            'full_name' => 'Member Name',
            'designation_id' => 'Designation',
            'department_id' => 'Department',
            'id_no' => 'Punch Card No',
            'contact_no' => 'Personal (Contact No)',
            'contact_no_home' => 'Home (Contact No)',
            'contact_no_office' => 'Office (Contact No)',
            'national_id_no' => 'NID/ Birth Certificate',
            'email' => 'Company Email',
            'p_email' => 'Personal Email',
            'address' => 'Present Address',
            'permanent_date' => 'Permanent Date',
            'contract_start_date' => 'Contract Start Date',
            'is_active' => 'Is Active',
            'permanent_address' => 'Permanent Address',
            'father_name' => 'Father Name',
            'father_occupation' => 'Father Occupation',
            'mother_name' => 'Mother Name',
            'mother_occopation' => 'Mother Occupation',
            'spouse_name' => 'Spouse Name',
            'spouse_details' => 'Spouse Details',
            'spouse_relation' => 'Relation (with spouse)',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'marrage_date' => 'Marrage Date',
            'country_id' => 'Country',
            'blood_group' => 'Blood Group',
            'dob' => 'Date Of Birth',
            'section_id' => 'Section',
            'sub_department_id' => 'Sub-Department',
            'branch_id' => 'Branch',
            'employee_type' => 'Employee Type',
            'bank_ac_no' => 'Bank A/C No',
            'bank' => 'Bank Name',
            'prev_info' => 'Previous Experiences</br>(Employment History)',
            'job_res' => 'Job Responsibility',
            'edu_info' => 'Academic / Educational Records',
            'contact_end' => 'Contact End',
            'skills' => 'Skill List',
            'photo' => 'Photo',
            'files' => 'File Name',
            'stuff_cat_id' => 'Stuff Category',
            'stuff_sub_cat_id' => 'Stuff Sub-Category',
            'startDate' => 'Start Date',
            'endDate' => 'End Date',
            'shift_id' => 'Shift',
            'religion' => 'Religion',
            'reference' => 'Reference Details',
            'tin' => 'TIN',
            'bank_name' => 'Personal Bank Name',
            'ac_no' => 'Bank A/C No',
            'bank_branch' => 'Bank Branch',
            'reference_name' => 'Reference Name',
            'reference_no' => 'Reference Contact No.',
            'pf_openning' => 'PF Opening Balance',
            'monthly_installment' > 'Monthly Installment',
            'opening_balance' => 'Opening Balance',
        );
    }

    public static function nameWithIdNo($id) {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->full_name . "<b> (".$data->emp_id_no.")</b>";
    }

    protected function afterDelete()
    {
        if ($this->photo != "") {
            unlink(Yii::app()->basePath . '/../upload/empPhoto/' . $this->photo); //delete file
        }
    }

    public function checkedIdsFirst($ids)
    {
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('is_active' => self::ACTIVE));
        if ($ids != "" || $ids != NULL) {
            if (is_array($ids))
                if (count($ids) > 1) {
                    $ids = implode(",", $ids);
                    $criteria->order = "FIELD(id, " . $ids . ") DESC";
                }
        }
        $data = self::model()->findAll($criteria);
        if ($data)
            return $data;
    }

    public function getNameWithIdNo()
    {
        return $this->full_name . ' (' . $this->emp_id_no . ')';
    }

    public function getNameWithCardNo()
    {
        return $this->full_name . ' (' . $this->id_no . ')';
    }

    public function fullName($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->full_name . '(' . $data->id . ')';
    }

    public function nameOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->full_name;
    }

    public function designationId($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return Designations::model()->infoOfThis($data->designation_id);
    }

    public function departmentId($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return Departments::model()->nameOfThis($data->department_id);
    }

    public function fullNameAndIdNo($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data->full_name . " (" . $data->emp_id_no . ")";
    }

    public function infoOfThis($id)
    {
        $data = self::model()->findByPk($id);
        if ($data)
            return $data;
    }

    public function statusColor($status)
    {
        if ($status == self::ACTIVE) {
            echo "<span class='greenColor'>ACTIVE</b></span>";
        } else {
            echo "<span class='redColor'>INACTIVE</b></span>";
        }
    }

    protected function beforeValidate()
    {
        if ($this->emp_id_no != "") {

        } else {
            $this->emp_id_no = date('Ymdhms');
        }
        return parent::beforeValidate();
    }


    public function beforeSave()
    {
        if ($this->designation_id == "") {
            $this->designation_id = NULL;
        }
        if ($this->department_id == "") {
            $this->department_id = NULL;
        }
        if ($this->contact_end == "") {
            $this->contact_end = NULL;
        }
//
//        if ($this->isNewRecord) {
//            $this->created_at = new CDbExpression('NOW()');
//            $this->created_by = Yii::app()->user->id;
//        } else {
//            $this->updated_at = new CDbExpression('NOW()');
//            $this->updated_by = Yii::app()->user->id;
//        }
        return parent::beforeSave();
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('emp_id_no', $this->emp_id_no, true);
        //$criteria->compare('device_id', $this->device_id, true);
        $criteria->compare('full_name', $this->full_name, true);
        $criteria->compare('designation_id', $this->designation_id);
        $criteria->compare('department_id', $this->department_id);
        $criteria->compare('id_no', $this->id_no);
        $criteria->compare('contact_no', $this->contact_no, true);
        $criteria->compare('contact_no_office', $this->contact_no_office, true);
        $criteria->compare('contact_no_home', $this->contact_no_home, true);
        $criteria->compare('national_id_no', $this->national_id_no, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('join_date', $this->join_date, true);
        $criteria->compare('permanent_date', $this->permanent_date, true);
        $criteria->compare('permanent_address', $this->permanent_address, true);
        $criteria->compare('father_name', $this->father_name, true);
        $criteria->compare('father_occupation', $this->father_occupation, true);
        $criteria->compare('mother_name', $this->mother_name, true);
        $criteria->compare('mother_occopation', $this->mother_occopation, true);
        $criteria->compare('spouse_name', $this->spouse_name, true);
        $criteria->compare('spouse_details', $this->spouse_details, true);
        $criteria->compare('dob', $this->dob, true);
        $criteria->compare('bank_ac_no', $this->bank_ac_no, true);
        $criteria->compare('bank', $this->bank, true);
        $criteria->compare('gender', $this->gender);
        $criteria->compare('marital_status', $this->marital_status);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('blood_group', $this->blood_group);
        $criteria->compare('section_id', $this->section_id);
        $criteria->compare('sub_department_id', $this->sub_department_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('employee_type', $this->employee_type);
        $criteria->compare('spouse_relation', $this->spouse_relation);
        $criteria->compare('prev_info', $this->prev_info, true);
        $criteria->compare('edu_info', $this->edu_info, true);
        $criteria->compare('contact_end', $this->contact_end, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('stuff_cat_id', $this->stuff_cat_id);
        $criteria->compare('stuff_sub_cat_id', $this->stuff_sub_cat_id);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('religion', $this->religion);
        $criteria->compare('reference', $this->reference, true);
        $criteria->compare('monthly_installment', $this->monthly_installment);
        $criteria->compare('opening_balance', $this->opening_balance, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
            'sort' => array(
                'defaultOrder' => 'department_id ASC',
            ),
        ));
    }


    public static function filterDataControl()
    {
        $data = CHtml::listData(self::model()->findAll(array('order' => ' full_name asc')), 'id', 'nameWithId');
        return $data;
    }


    public function getNameWithId() {
        return $this->full_name . ' || ' . $this->id;
    }



}