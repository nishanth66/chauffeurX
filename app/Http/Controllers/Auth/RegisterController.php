<?php

namespace App\Http\Controllers\Auth;

use App\Models\driver;
use App\Models\passengers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $sid    = "sid";
    protected $token  = "token";
    protected $redirectTo = '/home';
    private $database;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $config = array(
            "type"=> "service_account",
            "project_id"=> "driverapp-master-bb0a8",
            "private_key_id"=> "5133dcc7296c8d6c3c5344f2442ac8108958e788",
            "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDJxY02bLvVQMRN\nSQRwQNjjzzYKx3CTvb418mmg60TYiFCjx8U9EO4JrqtEl6rbttKC55gYD7TTUH3c\nPQMfhKybk4wEBRYFDtNAVNVlQW+W3EzqoN2sXxCaDbr644CAGW40GIq+MSo+HGxU\n13TifJ4FB3lCj2xSLY7XtaUAiyCZ9AiW/wlFd5GuF+gjIagkb2kPGuocg9WM1qvs\nWTDxtIcubnmQXz2xOATnIS1c9s4oNcI7DxfdTxSzB9AZ0bZUvTF+OzEGIz3gARqq\nlqDyE+LejdBtm18q0uHFSRKrtmfRnr8GWpe1QpoKIZ/kTEKpdlUYGUC97mZFjo7S\nify8LrV/AgMBAAECggEAGn5/v+VANszV2eYcGJdTQ3qaeIjere+s0c2edBxggmRH\n3nGlYxLdhtTyNUQLEeWsN7csYABz+IlptWknh1R3C8iwiniWfxyGvbxF9xFEE1Wj\nHe34naEv/2KNKlOENI3iTCHq2fV/u/8kdHGELhc58qQcFpLZoOLNjmKSI4OhSMWo\nSS0s6pHF56H3cixgueCTwTAzURcIdvzfFo2PE0QrPbTEoC+0AA+hvfBTtS/Zf94A\nulg5Eh6TBC1Qzjt6EyuVJ/HldmCRG97XUUY09q99szWmVLO1ANulYlCuRLGeTtlf\nLWW1YRYJIWJfVVa8vnosl/HAWtt8FKPqJxV2SatobQKBgQDkVeEDiOpZm7ox3zqj\nbFVv7rTLSjq9hZHk6Gh77oaxnOlmH4gih8mGh/z5Qyi4R9y5zXeOJHuJg72mnqsK\nGEMZ5nVPpKwRE4N1mSPw0Y/uVeNmyVDhWFmdu9XIpj49XAGMXr54kLjQSZ1IoueE\nB0WZ7cAxKYu5TzgTnIgQev4BZQKBgQDiN8M2bWpLj0xhlQvlA74e+Ti5YrQkVCiH\nbi6vIJ9p2mc2qg0ysymxAFiWDAtvnvIhXJ83MI81IUSwWBWLHzMluPh8No10/DVw\nlqkiqV/YEtJg4qCucar7qQEJsbODjpFQBfXZemE8DD3Q1LhwemOwI94K0Q/nCtWp\ndHX9eZ3/EwKBgH7B5h5uPZrtRpo1EHp0w6FV5OwOEznvEqT/GDHkosWrFC7rRknV\nE90pVRiTXeGfkztagwpX2nTmu7vpzY3XFjkkpO9HvXXlXU9Fapxf2gU3jPwcule/\nElDsW6v+DgNGNl3UouyPeum2VChktx2mY88mG1GvfK+s+LZ6aVas0KG5AoGBAJtn\nr2XOmL07vj8zQy6a+ZsRntRMaHCkmAshuFR61sjDTzCQdeykhDmigTjjIWAXE0Oz\n+3TQmTDon+V9PZ+LWXnKrnm2iEsbkCK+fYbgUIWBuKDyT2xHjizAl4PvXeE8qbsN\nvS0gE3hK+JRj7ijnC2DP4xQPNxuDp/B3ny74w3+dAoGBALjSMp+8nOxWE2sco4wS\nIzOprQ10K54naiy6xx6VsNamaqe9r4KiXXT9qpSjfCg3yMD5swtWVIcwwk0VM8J3\nj/8sgwfGCepyzcmXxZKqmJmfHlxr6Hd+/AA4Nm/MEbeWG+o3eMmZ4LzSS0sSH/fC\nO+f511UqvJxT2UvDVRtJcO70\n-----END PRIVATE KEY-----\n",
            "client_email"=> "driverapp-master-bb0a8@appspot.gserviceaccount.com",
            "client_id"=> "117555270648372527156",
            "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
            "token_uri"=> "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/driverapp-master-bb0a8%40appspot.gserviceaccount.com"
        );


        $serviceAccount = ServiceAccount::fromArray($config);

        $firebase = (new Factory())
            ->withServiceAccount($serviceAccount)
            ->create();


        $this->database = $firebase->getDatabase();
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        if ($data['status'] == 1)
        {
            $array['email'] = $data['email'];
            $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $array['otp'] = $email_otp;
            $input['password'] = Hash::make($data['password']);
            $input['email'] = $data['email'];
            $input['email_otp'] = $email_otp;
            $i=1;
            $j = 6;
            while($i != 0)
            {
                $string = "";
                for($i=0;$i < $j;$i++){
                    srand((double)microtime()*1234567);
                    $x = mt_rand(0,2);
                    switch($x){
                        case 0:$string.= chr(mt_rand(97,122));break;
                        case 1:$string.= chr(mt_rand(65,90));break;
                        case 2:$string.= chr(mt_rand(48,57));break;
                    }
                }
                if (driver::where('referal_code','like',$string)->exists() || passengers::where('referral_code','like',$string)->exists())
                {
                    if ($i > 99)
                    {
                        $j++;
                    }

                    $i=1;
                }
                else
                {
                    $i=0;
                    $input['referal_code'] = $string;
                    $driver = driver::create($input);
                }
            }
            Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Verify Email");
            });
            $reference = $this->database->getReference('user');
            $postRef = $reference->push([
                'userid ' => 'driver_'.$driver->id,
                'email' => $driver->email,
                'message' => [
                    'idSender' => '',
                    'idReceiver' => '',
                    'text' => '',
                    'timestamp' => '',
                ],
                'status' => [
                    'isOnline' => true,
                    'timestamp' => ''
                ],
                'usertype'=> 'driver',
                'username' => $driver->first_name
        ]);
//
            $postKey = $postRef->getKey();
            $updateKey['firebase_key'] = $postKey;
            driver::whereId($driver->id)->update($updateKey);
        }
        if ($data['status'] == 1)
        {
            return User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => $data['status'],

            ]);
        }
        else
        {
            return User::create([

                'fname' => $data['name'],
                'lname' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
                'status' => $data['status'],
            ]);
        }
    }
}
