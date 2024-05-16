<?php

/**
 * This is the model class for table "login_history".
 *
 * The followings are the available columns in table 'login_history':
 * @property string $id
 * @property boolean $status
 * @property integer $user_id
 * @property string $username
 * @property string $ip
 * @property string $hostname
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $loc
 * @property string $postal
 * @property string $browser
 * @property integer $mobile_desktop
 * @property string $created_at
 */
class LoginHistory extends CActiveRecord
{
    const STATUS_SUCCESS = 1;
    const STATUS_FAILED = 0;
    const DESKTOP = 1;
    const MOBILE = 2;
    const IP_STACK_ACCESS_KEY = "367111113a98b3b943111b0d584809f8";

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LoginHistory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function saveLoginInformation($data = [])
    {
        $dateTime = date('Y-m-d H:i:s');
        $user_id = Yii::app()->user->getState('user_id');

        $location = self::locationInformation();
        $browserInformation = self::browserInformation();
        $mobileOrDesktop = self::mobileOrDesktop();
        $hostname = $city = $region = $country = $loc = $postal = "";
        $ip = self::ipAddress();
        if (isset($location)) {
            // Output the "capital" object inside "location"
            $hostname = isset($location['hostname']) ? $location['hostname'] : '';
            $city = isset($location['city']) ? $location['city'] : '';
            $region = isset($location['region_name']) ? $location['region_name'] : '';
            $country = isset($location['country_name']) ? $location['country_name'] : '';
            $latitude = isset($location['latitude']) ? $location['latitude'] : '';
            $longitude = isset($location['longitude']) ? $location['longitude'] : '';
            $loc = "$latitude, $longitude";
            $postal = isset($location['zip']) ? $location['zip'] : '';
        } else {
            $latitude = isset($data['lat']) ? $data['lat'] : '';
            $longitude = isset($data['long']) ? $data['long'] : '';
            $hostname = isset($data['error']) ? $data['error'] : '';
            $loc = "$latitude, $longitude";
        }
        $model = new LoginHistory();
        $model->user_id = $user_id;
        $model->ip = $ip;
        $model->hostname = $hostname;
        $model->city = $city;
        $model->region = $region;
        $model->country = $country;
        $model->loc = $loc;
        $model->postal = $postal;
        $model->browser = $browserInformation;
        $model->mobile_desktop = $mobileOrDesktop;
        $model->created_at = $dateTime;
        if (isset($data['status']))
            $model->status = $data['status'];
        if (isset($data['username']))
            $model->username = $data['username'];
        else
            $model->username = Yii::app()->user->name;
        if (isset($data['remarks']))
            $model->remarks = $data['remarks'];
//        $model->validate();
//        var_dump($model->getErrors());
        $model->save();
//        die();
    }

    public static function locationInformation()
    {
        return null;
        // set IP address and API access key
        $ip = self::ipAddress();

        $whitelist = array(
            '127.0.0.1',
            '182.163.102.201',
            '192.168.1.61',
            '192.168.1.70',
            '::1'
        );
        $result = ['hostname' => '', 'city' => '', 'region_name' => '', 'latitude' => '', 'longitude' => '', 'zip' => '', 'country_name' => ''];

        if (in_array($ip, $whitelist)) {
            /*$access_key = self::IP_STACK_ACCESS_KEY;
            // Initialize CURL:
            $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);
            // Decode JSON response:
            $api_result = json_decode($json, true);
            if ($api_result){
                $hostname = isset($location['hostname']) ? $location['hostname'] : '';
                $city = isset($location['city']) ? $location['city'] : '';
                $region = isset($location['region_name']) ? $location['region_name'] : '';
                $country = isset($location['country_name']) ? $location['country_name'] : '';
                $latitude = isset($location['latitude']) ? $location['latitude'] : '';
                $longitude = isset($location['longitude']) ? $location['longitude'] : '';
                $loc ="$latitude, $longitude";
                $postal = isset($location['zip']) ? $location['zip'] : '';
            }
            return  $api_result;
*/
            /* $curl = curl_init();
             curl_setopt_array($curl, array(
                 CURLOPT_URL => "https://freegeoip.app/json/$ip",
                 CURLOPT_RETURNTRANSFER => true,
                 CURLOPT_ENCODING => "",
                 CURLOPT_MAXREDIRS => 10,
                 CURLOPT_TIMEOUT => 30,
                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                 CURLOPT_CUSTOMREQUEST => "GET",
                 CURLOPT_HTTPHEADER => array(
                     "accept: application/json",
                     "content-type: application/json"
                 ),
             ));
             $response = curl_exec($curl);
             $err = curl_error($curl);
             curl_close($curl);
             if (!$err) {
                 $api_result = json_decode($response, true);
                 $result = [
                     'hostname' => isset($api_result['time_zone']) ? $api_result['time_zone'] : '',
                     'city' => isset($api_result['city']) ? $api_result['city'] : '',
                     'region_name' => isset($api_result['region_name']) ? $api_result['region_name'] : '',
                     'country_name' => isset($api_result['country_name']) ? $api_result['country_name'] : '',
                     'latitude' => isset($api_result['latitude']) ? $api_result['latitude'] : '',
                     'longitude' => isset($api_result['longitude']) ? $api_result['longitude'] : '',
                     'zip' => isset($api_result['zip_code']) ? $api_result['zip_code'] : '',
                 ];
                 return  $result;
             } else{
                 return null;
             }*/
        } else {
            return null;
        }
    }

    public static function ipAddress()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        return $ip;
    }

    public static function browserInformation()
    {
        return $_SERVER['HTTP_USER_AGENT'] . "\n\n";
    }

    public static function mobileOrDesktop()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $value = self::DESKTOP;
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
            $value = self::MOBILE;
        return $value;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'login_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
//            array('username', 'required'),
            array('user_id, mobile_desktop, status', 'numerical', 'integerOnly' => true),
            array('ip, hostname, city, region, country, loc, postal, browser, username', 'length', 'max' => 255),
            // The following rule is used by search().

            array('id, user_id, ip, hostname, city, username, region, country, loc, postal, status, browser, mobile_desktop, created_at', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'ip' => 'Ip',
            'hostname' => 'Hostname',
            'city' => 'City',
            'region' => 'Region',
            'country' => 'Country',
            'loc' => 'Loc',
            'postal' => 'Postal',
            'browser' => 'Browser',
            'mobile_desktop' => 'Mobile Desktop',
            'created_at' => 'Created At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('hostname', $this->hostname, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('region', $this->region, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('loc', $this->loc, true);
        $criteria->compare('postal', $this->postal, true);
        $criteria->compare('browser', $this->browser, true);
        $criteria->compare('mobile_desktop', $this->mobile_desktop);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
