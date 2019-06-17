<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverRequest;
use App\Http\Requests\UpdatedriverRequest;
use App\Models\advertisement_users;
use App\Models\availableCities;
use App\Models\booking;
use App\Models\driver;
use App\Models\driverBasicDetails;
use App\Models\driverCategory;
use App\Models\driverPaymentHistory;
use App\Models\driverStripe;
use App\Models\driverSubscription;
use App\Models\driverVerification;
use App\Models\rating;
use App\Repositories\driverRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverController extends Controller
{
    /** @var  driverRepository */
    private $driverRepository;
    protected $sid    = "AC7835895b4de3218265df779b550d793b";
    protected $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";
    private $database;

    public function __construct(driverRepository $driverRepo)
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

        $this->middleware('auth');
        $this->driverRepository = $driverRepo;
    }

    /**
     * Display a listing of the driver.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->status == 0)
        {
            $code = 1;
            if ($message = Session::get(''.$code.''))
            {
                $msg = explode('-',$message);
                $sessionCode = $msg[1];
                if ($sessionCode == $msg[1])
                {
                    $Sessioncity = $msg[0];
                    if ($Sessioncity == 'all')
                    {
                        $drivers = driver::where('status',1)->get();
                    }
                    else
                    {
                        $driverCity = driverBasicDetails::where('city','like',$Sessioncity)->get();
                        $drivers = [];
                        foreach ($driverCity as $driversCity)
                        {
                            if (driver::whereId($driversCity->driverid)->where('status',1)->exists())
                            {
                                array_push($drivers,driver::whereId($driversCity->driverid)->where('status',1)->first());
                            }
                        }
                    }

                }
            }
            else
            {
                $drivers = driver::where('status',1)->get();
            }
            $cities = availableCities::get();
            return view('drivers.index',compact('drivers','cities','code'));
        }
        else
        {
            return view('errors.404');
        }
    }

    public function pending()
    {
        if (Auth::user()->status == 0)
        {
            $code = 0;
            if ($message = Session::get(''.$code.''))
            {
                $msg = explode('-',$message);
                $sessionCode = $msg[1];
                if ($sessionCode == $msg[1])
                {
                    $Sessioncity = $msg[0];
                    if ($Sessioncity != 'all')
                    {
                        $driverCity = driverBasicDetails::where('city','like',$Sessioncity)->get();
                        $drivers = [];
                        foreach ($driverCity as $driversCity)
                        {
                            if (driver::whereId($driversCity->driverid)->where('status',0)
                                ->where('activated', 1)
                                ->where('basic_details', 1)
                                ->where('address_details', 1)
                                ->where('licence_details', 1)
                                ->where('documents', 1)
                                ->where('signature','!=',null)
                                ->exists())
                            {
                                array_push($drivers,driver::whereId($driversCity->driverid)->where('status',0)
                                    ->where('activated', 1)
                                    ->where('basic_details', 1)
                                    ->where('address_details', 1)
                                    ->where('licence_details', 1)
                                    ->where('documents', 1)
                                    ->where('signature','!=',null)
                                    ->first());
                            }
                        }
                    }
                    else
                    {
                        $drivers = driver::where('status', 0)
                            ->where('activated', 1)
                            ->where('basic_details', 1)
                            ->where('address_details', 1)
                            ->where('licence_details', 1)
                            ->where('documents', 1)
                            ->where('signature','!=',null)
                            ->get();
                    }

                }
            }
            else
            {
                $drivers = driver::where('status', 0)
                    ->where('activated', 1)
                    ->where('basic_details', 1)
                    ->where('address_details', 1)
                    ->where('licence_details', 1)
                    ->where('documents', 1)
                    ->get();
            }

            $cities = availableCities::get();

            return view('drivers.index',compact('drivers','cities','code'));
        }
        else
        {
            return view('errors.404');
        }
    }

    public function rejected()
    {
        if (Auth::user()->status == 0)
        {
            $code = 2;
            if ($message = Session::get(''.$code.''))
            {
                $msg = explode('-',$message);
                $sessionCode = $msg[1];
                if ($sessionCode == $msg[1])
                {
                    $Sessioncity = $msg[0];
                    if ($Sessioncity == 'all')
                    {
                        $drivers = driver::where('status',2)->get();
                    }
                    else
                    {
                        $driverCity = driverBasicDetails::where('city','like',$Sessioncity)->get();
                        $drivers = [];
                        foreach ($driverCity as $driversCity)
                        {
                            if (driver::whereId($driversCity->driverid)->where('status',2)->exists())
                            {
                                array_push($drivers,driver::whereId($driversCity->driverid)->where('status',2)->first());
                            }
                        }
                    }

                }
            }
            else
            {
                $drivers = driver::where('status', 2)
                    ->get();
            }

            $cities = availableCities::get();

            return view('drivers.index',compact('drivers','cities','code'));
        }
        else
        {
            return view('errors.404');
        }
    }

    /**
     * Show the form for creating a new driver.
     *
     * @return Response
     */
    public function create()
    {
        return view('drivers.create');
    }

    /**
     * Store a newly created driver in storage.
     *
     * @param CreatedriverRequest $request
     *
     * @return Response
     */
    public function store(CreatedriverRequest $request)
    {
        $input = $request->all();

        $driver = $this->driverRepository->create($input);

        Flash::success('Driver saved successfully.');

        return redirect(route('drivers.index'));
    }

    /**
     * Display the specified driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        return view('drivers.show')->with('driver', $driver);
    }

    /**
     * Show the form for editing the specified driver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        return view('drivers.edit')->with('driver', $driver);
    }

    /**
     * Update the specified driver in storage.
     *
     * @param  int              $id
     * @param UpdatedriverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedriverRequest $request)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        $driver = $this->driverRepository->update($request->all(), $id);

        Flash::success('Driver updated successfully.');

        return redirect(route('drivers.index'));
    }

    /**
     * Remove the specified driver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $driver = $this->driverRepository->findWithoutFail($id);

        if (empty($driver)) {
            Flash::error('Driver not found');

            return redirect(route('drivers.index'));
        }

        driver::whereId($id)->forcedelete();

        Flash::success('Driver deleted successfully.');

        return redirect()->back();
    }
    public function verification()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated == 1)
            {
                return redirect('driver/profile');
            }
            return view('drivers.FrontEnd.verification_code',compact('driver'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function resendOtp()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $array['email'] = $driver->email;
            $array['otp'] = $email_otp;
            $input['email_otp'] = $email_otp;
            Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Verify Email");
            });
            $driver = driver::whereId($driver->id)->update($input);
            Flash::success("OTP sent Successfully!");
            return redirect()->back();
        }
        else
        {
            Flash::error("Driver not Found");
            return redirect()->back();
        }
    }
    public function verifyOtp(Request $request)
    {
        if (driver::whereId($request->driverid)->where('email',$request->email)->where('email_otp',$request->email_otp)->exists())
        {
            driver::whereId($request->driverid)->update(['activated'=>1]);
            Flash::success("Email Verified Successfully");
            return redirect('driver/profile');
        }
        Flash::error("Email Verification Failed");
        return redirect()->back();
    }


    public function profile()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $countryArray = array(
                'AD'=>array('name'=>'ANDORRA','code'=>'376'),
                'AE'=>array('name'=>'UNITED ARAB EMIRATES','code'=>'971'),
                'AF'=>array('name'=>'AFGHANISTAN','code'=>'93'),
                'AG'=>array('name'=>'ANTIGUA AND BARBUDA','code'=>'1268'),
                'AI'=>array('name'=>'ANGUILLA','code'=>'1264'),
                'AL'=>array('name'=>'ALBANIA','code'=>'355'),
                'AM'=>array('name'=>'ARMENIA','code'=>'374'),
                'AN'=>array('name'=>'NETHERLANDS ANTILLES','code'=>'599'),
                'AO'=>array('name'=>'ANGOLA','code'=>'244'),
                'AQ'=>array('name'=>'ANTARCTICA','code'=>'672'),
                'AR'=>array('name'=>'ARGENTINA','code'=>'54'),
                'AS'=>array('name'=>'AMERICAN SAMOA','code'=>'1684'),
                'AT'=>array('name'=>'AUSTRIA','code'=>'43'),
                'AU'=>array('name'=>'AUSTRALIA','code'=>'61'),
                'AW'=>array('name'=>'ARUBA','code'=>'297'),
                'AZ'=>array('name'=>'AZERBAIJAN','code'=>'994'),
                'BA'=>array('name'=>'BOSNIA AND HERZEGOVINA','code'=>'387'),
                'BB'=>array('name'=>'BARBADOS','code'=>'1246'),
                'BD'=>array('name'=>'BANGLADESH','code'=>'880'),
                'BE'=>array('name'=>'BELGIUM','code'=>'32'),
                'BF'=>array('name'=>'BURKINA FASO','code'=>'226'),
                'BG'=>array('name'=>'BULGARIA','code'=>'359'),
                'BH'=>array('name'=>'BAHRAIN','code'=>'973'),
                'BI'=>array('name'=>'BURUNDI','code'=>'257'),
                'BJ'=>array('name'=>'BENIN','code'=>'229'),
                'BL'=>array('name'=>'SAINT BARTHELEMY','code'=>'590'),
                'BM'=>array('name'=>'BERMUDA','code'=>'1441'),
                'BN'=>array('name'=>'BRUNEI DARUSSALAM','code'=>'673'),
                'BO'=>array('name'=>'BOLIVIA','code'=>'591'),
                'BR'=>array('name'=>'BRAZIL','code'=>'55'),
                'BS'=>array('name'=>'BAHAMAS','code'=>'1242'),
                'BT'=>array('name'=>'BHUTAN','code'=>'975'),
                'BW'=>array('name'=>'BOTSWANA','code'=>'267'),
                'BY'=>array('name'=>'BELARUS','code'=>'375'),
                'BZ'=>array('name'=>'BELIZE','code'=>'501'),
                'CA'=>array('name'=>'CANADA','code'=>'1'),
                'CC'=>array('name'=>'COCOS (KEELING) ISLANDS','code'=>'61'),
                'CD'=>array('name'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE','code'=>'243'),
                'CF'=>array('name'=>'CENTRAL AFRICAN REPUBLIC','code'=>'236'),
                'CG'=>array('name'=>'CONGO','code'=>'242'),
                'CH'=>array('name'=>'SWITZERLAND','code'=>'41'),
                'CI'=>array('name'=>'COTE D IVOIRE','code'=>'225'),
                'CK'=>array('name'=>'COOK ISLANDS','code'=>'682'),
                'CL'=>array('name'=>'CHILE','code'=>'56'),
                'CM'=>array('name'=>'CAMEROON','code'=>'237'),
                'CN'=>array('name'=>'CHINA','code'=>'86'),
                'CO'=>array('name'=>'COLOMBIA','code'=>'57'),
                'CR'=>array('name'=>'COSTA RICA','code'=>'506'),
                'CU'=>array('name'=>'CUBA','code'=>'53'),
                'CV'=>array('name'=>'CAPE VERDE','code'=>'238'),
                'CX'=>array('name'=>'CHRISTMAS ISLAND','code'=>'61'),
                'CY'=>array('name'=>'CYPRUS','code'=>'357'),
                'CZ'=>array('name'=>'CZECH REPUBLIC','code'=>'420'),
                'DE'=>array('name'=>'GERMANY','code'=>'49'),
                'DJ'=>array('name'=>'DJIBOUTI','code'=>'253'),
                'DK'=>array('name'=>'DENMARK','code'=>'45'),
                'DM'=>array('name'=>'DOMINICA','code'=>'1767'),
                'DO'=>array('name'=>'DOMINICAN REPUBLIC','code'=>'1809'),
                'DZ'=>array('name'=>'ALGERIA','code'=>'213'),
                'EC'=>array('name'=>'ECUADOR','code'=>'593'),
                'EE'=>array('name'=>'ESTONIA','code'=>'372'),
                'EG'=>array('name'=>'EGYPT','code'=>'20'),
                'ER'=>array('name'=>'ERITREA','code'=>'291'),
                'ES'=>array('name'=>'SPAIN','code'=>'34'),
                'ET'=>array('name'=>'ETHIOPIA','code'=>'251'),
                'FI'=>array('name'=>'FINLAND','code'=>'358'),
                'FJ'=>array('name'=>'FIJI','code'=>'679'),
                'FK'=>array('name'=>'FALKLAND ISLANDS (MALVINAS)','code'=>'500'),
                'FM'=>array('name'=>'MICRONESIA, FEDERATED STATES OF','code'=>'691'),
                'FO'=>array('name'=>'FAROE ISLANDS','code'=>'298'),
                'FR'=>array('name'=>'FRANCE','code'=>'33'),
                'GA'=>array('name'=>'GABON','code'=>'241'),
                'GB'=>array('name'=>'UNITED KINGDOM','code'=>'44'),
                'GD'=>array('name'=>'GRENADA','code'=>'1473'),
                'GE'=>array('name'=>'GEORGIA','code'=>'995'),
                'GH'=>array('name'=>'GHANA','code'=>'233'),
                'GI'=>array('name'=>'GIBRALTAR','code'=>'350'),
                'GL'=>array('name'=>'GREENLAND','code'=>'299'),
                'GM'=>array('name'=>'GAMBIA','code'=>'220'),
                'GN'=>array('name'=>'GUINEA','code'=>'224'),
                'GQ'=>array('name'=>'EQUATORIAL GUINEA','code'=>'240'),
                'GR'=>array('name'=>'GREECE','code'=>'30'),
                'GT'=>array('name'=>'GUATEMALA','code'=>'502'),
                'GU'=>array('name'=>'GUAM','code'=>'1671'),
                'GW'=>array('name'=>'GUINEA-BISSAU','code'=>'245'),
                'GY'=>array('name'=>'GUYANA','code'=>'592'),
                'HK'=>array('name'=>'HONG KONG','code'=>'852'),
                'HN'=>array('name'=>'HONDURAS','code'=>'504'),
                'HR'=>array('name'=>'CROATIA','code'=>'385'),
                'HT'=>array('name'=>'HAITI','code'=>'509'),
                'HU'=>array('name'=>'HUNGARY','code'=>'36'),
                'ID'=>array('name'=>'INDONESIA','code'=>'62'),
                'IE'=>array('name'=>'IRELAND','code'=>'353'),
                'IL'=>array('name'=>'ISRAEL','code'=>'972'),
                'IM'=>array('name'=>'ISLE OF MAN','code'=>'44'),
                'IN'=>array('name'=>'INDIA','code'=>'91'),
                'IQ'=>array('name'=>'IRAQ','code'=>'964'),
                'IR'=>array('name'=>'IRAN, ISLAMIC REPUBLIC OF','code'=>'98'),
                'IS'=>array('name'=>'ICELAND','code'=>'354'),
                'IT'=>array('name'=>'ITALY','code'=>'39'),
                'JM'=>array('name'=>'JAMAICA','code'=>'1876'),
                'JO'=>array('name'=>'JORDAN','code'=>'962'),
                'JP'=>array('name'=>'JAPAN','code'=>'81'),
                'KE'=>array('name'=>'KENYA','code'=>'254'),
                'KG'=>array('name'=>'KYRGYZSTAN','code'=>'996'),
                'KH'=>array('name'=>'CAMBODIA','code'=>'855'),
                'KI'=>array('name'=>'KIRIBATI','code'=>'686'),
                'KM'=>array('name'=>'COMOROS','code'=>'269'),
                'KN'=>array('name'=>'SAINT KITTS AND NEVIS','code'=>'1869'),
                'KP'=>array('name'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF','code'=>'850'),
                'KR'=>array('name'=>'KOREA REPUBLIC OF','code'=>'82'),
                'KW'=>array('name'=>'KUWAIT','code'=>'965'),
                'KY'=>array('name'=>'CAYMAN ISLANDS','code'=>'1345'),
                'KZ'=>array('name'=>'KAZAKSTAN','code'=>'7'),
                'LA'=>array('name'=>'LAO PEOPLES DEMOCRATIC REPUBLIC','code'=>'856'),
                'LB'=>array('name'=>'LEBANON','code'=>'961'),
                'LC'=>array('name'=>'SAINT LUCIA','code'=>'1758'),
                'LI'=>array('name'=>'LIECHTENSTEIN','code'=>'423'),
                'LK'=>array('name'=>'SRI LANKA','code'=>'94'),
                'LR'=>array('name'=>'LIBERIA','code'=>'231'),
                'LS'=>array('name'=>'LESOTHO','code'=>'266'),
                'LT'=>array('name'=>'LITHUANIA','code'=>'370'),
                'LU'=>array('name'=>'LUXEMBOURG','code'=>'352'),
                'LV'=>array('name'=>'LATVIA','code'=>'371'),
                'LY'=>array('name'=>'LIBYAN ARAB JAMAHIRIYA','code'=>'218'),
                'MA'=>array('name'=>'MOROCCO','code'=>'212'),
                'MC'=>array('name'=>'MONACO','code'=>'377'),
                'MD'=>array('name'=>'MOLDOVA, REPUBLIC OF','code'=>'373'),
                'ME'=>array('name'=>'MONTENEGRO','code'=>'382'),
                'MF'=>array('name'=>'SAINT MARTIN','code'=>'1599'),
                'MG'=>array('name'=>'MADAGASCAR','code'=>'261'),
                'MH'=>array('name'=>'MARSHALL ISLANDS','code'=>'692'),
                'MK'=>array('name'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF','code'=>'389'),
                'ML'=>array('name'=>'MALI','code'=>'223'),
                'MM'=>array('name'=>'MYANMAR','code'=>'95'),
                'MN'=>array('name'=>'MONGOLIA','code'=>'976'),
                'MO'=>array('name'=>'MACAU','code'=>'853'),
                'MP'=>array('name'=>'NORTHERN MARIANA ISLANDS','code'=>'1670'),
                'MR'=>array('name'=>'MAURITANIA','code'=>'222'),
                'MS'=>array('name'=>'MONTSERRAT','code'=>'1664'),
                'MT'=>array('name'=>'MALTA','code'=>'356'),
                'MU'=>array('name'=>'MAURITIUS','code'=>'230'),
                'MV'=>array('name'=>'MALDIVES','code'=>'960'),
                'MW'=>array('name'=>'MALAWI','code'=>'265'),
                'MX'=>array('name'=>'MEXICO','code'=>'52'),
                'MY'=>array('name'=>'MALAYSIA','code'=>'60'),
                'MZ'=>array('name'=>'MOZAMBIQUE','code'=>'258'),
                'NA'=>array('name'=>'NAMIBIA','code'=>'264'),
                'NC'=>array('name'=>'NEW CALEDONIA','code'=>'687'),
                'NE'=>array('name'=>'NIGER','code'=>'227'),
                'NG'=>array('name'=>'NIGERIA','code'=>'234'),
                'NI'=>array('name'=>'NICARAGUA','code'=>'505'),
                'NL'=>array('name'=>'NETHERLANDS','code'=>'31'),
                'NO'=>array('name'=>'NORWAY','code'=>'47'),
                'NP'=>array('name'=>'NEPAL','code'=>'977'),
                'NR'=>array('name'=>'NAURU','code'=>'674'),
                'NU'=>array('name'=>'NIUE','code'=>'683'),
                'NZ'=>array('name'=>'NEW ZEALAND','code'=>'64'),
                'OM'=>array('name'=>'OMAN','code'=>'968'),
                'PA'=>array('name'=>'PANAMA','code'=>'507'),
                'PE'=>array('name'=>'PERU','code'=>'51'),
                'PF'=>array('name'=>'FRENCH POLYNESIA','code'=>'689'),
                'PG'=>array('name'=>'PAPUA NEW GUINEA','code'=>'675'),
                'PH'=>array('name'=>'PHILIPPINES','code'=>'63'),
                'PK'=>array('name'=>'PAKISTAN','code'=>'92'),
                'PL'=>array('name'=>'POLAND','code'=>'48'),
                'PM'=>array('name'=>'SAINT PIERRE AND MIQUELON','code'=>'508'),
                'PN'=>array('name'=>'PITCAIRN','code'=>'870'),
                'PR'=>array('name'=>'PUERTO RICO','code'=>'1'),
                'PT'=>array('name'=>'PORTUGAL','code'=>'351'),
                'PW'=>array('name'=>'PALAU','code'=>'680'),
                'PY'=>array('name'=>'PARAGUAY','code'=>'595'),
                'QA'=>array('name'=>'QATAR','code'=>'974'),
                'RO'=>array('name'=>'ROMANIA','code'=>'40'),
                'RS'=>array('name'=>'SERBIA','code'=>'381'),
                'RU'=>array('name'=>'RUSSIAN FEDERATION','code'=>'7'),
                'RW'=>array('name'=>'RWANDA','code'=>'250'),
                'SA'=>array('name'=>'SAUDI ARABIA','code'=>'966'),
                'SB'=>array('name'=>'SOLOMON ISLANDS','code'=>'677'),
                'SC'=>array('name'=>'SEYCHELLES','code'=>'248'),
                'SD'=>array('name'=>'SUDAN','code'=>'249'),
                'SE'=>array('name'=>'SWEDEN','code'=>'46'),
                'SG'=>array('name'=>'SINGAPORE','code'=>'65'),
                'SH'=>array('name'=>'SAINT HELENA','code'=>'290'),
                'SI'=>array('name'=>'SLOVENIA','code'=>'386'),
                'SK'=>array('name'=>'SLOVAKIA','code'=>'421'),
                'SL'=>array('name'=>'SIERRA LEONE','code'=>'232'),
                'SM'=>array('name'=>'SAN MARINO','code'=>'378'),
                'SN'=>array('name'=>'SENEGAL','code'=>'221'),
                'SO'=>array('name'=>'SOMALIA','code'=>'252'),
                'SR'=>array('name'=>'SURINAME','code'=>'597'),
                'ST'=>array('name'=>'SAO TOME AND PRINCIPE','code'=>'239'),
                'SV'=>array('name'=>'EL SALVADOR','code'=>'503'),
                'SY'=>array('name'=>'SYRIAN ARAB REPUBLIC','code'=>'963'),
                'SZ'=>array('name'=>'SWAZILAND','code'=>'268'),
                'TC'=>array('name'=>'TURKS AND CAICOS ISLANDS','code'=>'1649'),
                'TD'=>array('name'=>'CHAD','code'=>'235'),
                'TG'=>array('name'=>'TOGO','code'=>'228'),
                'TH'=>array('name'=>'THAILAND','code'=>'66'),
                'TJ'=>array('name'=>'TAJIKISTAN','code'=>'992'),
                'TK'=>array('name'=>'TOKELAU','code'=>'690'),
                'TL'=>array('name'=>'TIMOR-LESTE','code'=>'670'),
                'TM'=>array('name'=>'TURKMENISTAN','code'=>'993'),
                'TN'=>array('name'=>'TUNISIA','code'=>'216'),
                'TO'=>array('name'=>'TONGA','code'=>'676'),
                'TR'=>array('name'=>'TURKEY','code'=>'90'),
                'TT'=>array('name'=>'TRINIDAD AND TOBAGO','code'=>'1868'),
                'TV'=>array('name'=>'TUVALU','code'=>'688'),
                'TW'=>array('name'=>'TAIWAN, PROVINCE OF CHINA','code'=>'886'),
                'TZ'=>array('name'=>'TANZANIA, UNITED REPUBLIC OF','code'=>'255'),
                'UA'=>array('name'=>'UKRAINE','code'=>'380'),
                'UG'=>array('name'=>'UGANDA','code'=>'256'),
                'US'=>array('name'=>'UNITED STATES','code'=>'1'),
                'UY'=>array('name'=>'URUGUAY','code'=>'598'),
                'UZ'=>array('name'=>'UZBEKISTAN','code'=>'998'),
                'VA'=>array('name'=>'HOLY SEE (VATICAN CITY STATE)','code'=>'39'),
                'VC'=>array('name'=>'SAINT VINCENT AND THE GRENADINES','code'=>'1784'),
                'VE'=>array('name'=>'VENEZUELA','code'=>'58'),
                'VG'=>array('name'=>'VIRGIN ISLANDS, BRITISH','code'=>'1284'),
                'VI'=>array('name'=>'VIRGIN ISLANDS, U.S.','code'=>'1340'),
                'VN'=>array('name'=>'VIET NAM','code'=>'84'),
                'VU'=>array('name'=>'VANUATU','code'=>'678'),
                'WF'=>array('name'=>'WALLIS AND FUTUNA','code'=>'681'),
                'WS'=>array('name'=>'SAMOA','code'=>'685'),
                'XK'=>array('name'=>'KOSOVO','code'=>'381'),
                'YE'=>array('name'=>'YEMEN','code'=>'967'),
                'YT'=>array('name'=>'MAYOTTE','code'=>'262'),
                'ZA'=>array('name'=>'SOUTH AFRICA','code'=>'27'),
                'ZM'=>array('name'=>'ZAMBIA','code'=>'260'),
                'ZW'=>array('name'=>'ZIMBABWE','code'=>'263')
            );
            $array = json_decode('[
    {
      "code": "+840",
      "name": "Abkhazia"
    },
    {
      "code": "+93",
      "name": "Afghanistan"
    },
    {
      "code": "+355",
      "name": "Albania"
    },
    {
      "code": "+213",
      "name": "Algeria"
    },
    {
      "code": "+1 684",
      "name": "American Samoa"
    },
    {
      "code": "+376",
      "name": "Andorra"
    },
    {
      "code": "+244",
      "name": "Angola"
    },
    {
      "code": "+1 264",
      "name": "Anguilla"
    },
    {
      "code": "+1 268",
      "name": "Antigua and Barbuda"
    },
    {
      "code": "+54",
      "name": "Argentina"
    },
    {
      "code": "+374",
      "name": "Armenia"
    },
    {
      "code": "+297",
      "name": "Aruba"
    },
    {
      "code": "+247",
      "name": "Ascension"
    },
    {
      "code": "+61",
      "name": "Australia"
    },
    {
      "code": "+672",
      "name": "Australian External Territories"
    },
    {
      "code": "+43",
      "name": "Austria"
    },
    {
      "code": "+994",
      "name": "Azerbaijan"
    },
    {
      "code": "+1 242",
      "name": "Bahamas"
    },
    {
      "code": "+973",
      "name": "Bahrain"
    },
    {
      "code": "+880",
      "name": "Bangladesh"
    },
    {
      "code": "+1 246",
      "name": "Barbados"
    },
    {
      "code": "+1 268",
      "name": "Barbuda"
    },
    {
      "code": "+375",
      "name": "Belarus"
    },
    {
      "code": "+32",
      "name": "Belgium"
    },
    {
      "code": "+501",
      "name": "Belize"
    },
    {
      "code": "+229",
      "name": "Benin"
    },
    {
      "code": "+1 441",
      "name": "Bermuda"
    },
    {
      "code": "+975",
      "name": "Bhutan"
    },
    {
      "code": "+591",
      "name": "Bolivia"
    },
    {
      "code": "+387",
      "name": "Bosnia and Herzegovina"
    },
    {
      "code": "+267",
      "name": "Botswana"
    },
    {
      "code": "+55",
      "name": "Brazil"
    },
    {
      "code": "+246",
      "name": "British Indian Ocean Territory"
    },
    {
      "code": "+1 284",
      "name": "British Virgin Islands"
    },
    {
      "code": "+673",
      "name": "Brunei"
    },
    {
      "code": "+359",
      "name": "Bulgaria"
    },
    {
      "code": "+226",
      "name": "Burkina Faso"
    },
    {
      "code": "+257",
      "name": "Burundi"
    },
    {
      "code": "+855",
      "name": "Cambodia"
    },
    {
      "code": "+237",
      "name": "Cameroon"
    },
    {
      "code": "+1",
      "name": "Canada"
    },
    {
      "code": "+238",
      "name": "Cape Verde"
    },
    {
      "code": "+ 345",
      "name": "Cayman Islands"
    },
    {
      "code": "+236",
      "name": "Central African Republic"
    },
    {
      "code": "+235",
      "name": "Chad"
    },
    {
      "code": "+56",
      "name": "Chile"
    },
    {
      "code": "+86",
      "name": "China"
    },
    {
      "code": "+61",
      "name": "Christmas Island"
    },
    {
      "code": "+61",
      "name": "Cocos-Keeling Islands"
    },
    {
      "code": "+57",
      "name": "Colombia"
    },
    {
      "code": "+269",
      "name": "Comoros"
    },
    {
      "code": "+242",
      "name": "Congo"
    },
    {
      "code": "+243",
      "name": "Congo, Dem. Rep. of (Zaire)"
    },
    {
      "code": "+682",
      "name": "Cook Islands"
    },
    {
      "code": "+506",
      "name": "Costa Rica"
    },
    {
      "code": "+385",
      "name": "Croatia"
    },
    {
      "code": "+53",
      "name": "Cuba"
    },
    {
      "code": "+599",
      "name": "Curacao"
    },
    {
      "code": "+537",
      "name": "Cyprus"
    },
    {
      "code": "+420",
      "name": "Czech Republic"
    },
    {
      "code": "+45",
      "name": "Denmark"
    },
    {
      "code": "+246",
      "name": "Diego Garcia"
    },
    {
      "code": "+253",
      "name": "Djibouti"
    },
    {
      "code": "+1 767",
      "name": "Dominica"
    },
    {
      "code": "+1 809",
      "name": "Dominican Republic"
    },
    {
      "code": "+670",
      "name": "East Timor"
    },
    {
      "code": "+56",
      "name": "Easter Island"
    },
    {
      "code": "+593",
      "name": "Ecuador"
    },
    {
      "code": "+20",
      "name": "Egypt"
    },
    {
      "code": "+503",
      "name": "El Salvador"
    },
    {
      "code": "+240",
      "name": "Equatorial Guinea"
    },
    {
      "code": "+291",
      "name": "Eritrea"
    },
    {
      "code": "+372",
      "name": "Estonia"
    },
    {
      "code": "+251",
      "name": "Ethiopia"
    },
    {
      "code": "+500",
      "name": "Falkland Islands"
    },
    {
      "code": "+298",
      "name": "Faroe Islands"
    },
    {
      "code": "+679",
      "name": "Fiji"
    },
    {
      "code": "+358",
      "name": "Finland"
    },
    {
      "code": "+33",
      "name": "France"
    },
    {
      "code": "+596",
      "name": "French Antilles"
    },
    {
      "code": "+594",
      "name": "French Guiana"
    },
    {
      "code": "+689",
      "name": "French Polynesia"
    },
    {
      "code": "+241",
      "name": "Gabon"
    },
    {
      "code": "+220",
      "name": "Gambia"
    },
    {
      "code": "+995",
      "name": "Georgia"
    },
    {
      "code": "+49",
      "name": "Germany"
    },
    {
      "code": "+233",
      "name": "Ghana"
    },
    {
      "code": "+350",
      "name": "Gibraltar"
    },
    {
      "code": "+30",
      "name": "Greece"
    },
    {
      "code": "+299",
      "name": "Greenland"
    },
    {
      "code": "+1 473",
      "name": "Grenada"
    },
    {
      "code": "+590",
      "name": "Guadeloupe"
    },
    {
      "code": "+1 671",
      "name": "Guam"
    },
    {
      "code": "+502",
      "name": "Guatemala"
    },
    {
      "code": "+224",
      "name": "Guinea"
    },
    {
      "code": "+245",
      "name": "Guinea-Bissau"
    },
    {
      "code": "+595",
      "name": "Guyana"
    },
    {
      "code": "+509",
      "name": "Haiti"
    },
    {
      "code": "+504",
      "name": "Honduras"
    },
    {
      "code": "+852",
      "name": "Hong Kong SAR China"
    },
    {
      "code": "+36",
      "name": "Hungary"
    },
    {
      "code": "+354",
      "name": "Iceland"
    },
    {
      "code": "+91",
      "name": "India"
    },
    {
      "code": "+62",
      "name": "Indonesia"
    },
    {
      "code": "+98",
      "name": "Iran"
    },
    {
      "code": "+964",
      "name": "Iraq"
    },
    {
      "code": "+353",
      "name": "Ireland"
    },
    {
      "code": "+972",
      "name": "Israel"
    },
    {
      "code": "+39",
      "name": "Italy"
    },
    {
      "code": "+225",
      "name": "Ivory Coast"
    },
    {
      "code": "+1 876",
      "name": "Jamaica"
    },
    {
      "code": "+81",
      "name": "Japan"
    },
    {
      "code": "+962",
      "name": "Jordan"
    },
    {
      "code": "+7 7",
      "name": "Kazakhstan"
    },
    {
      "code": "+254",
      "name": "Kenya"
    },
    {
      "code": "+686",
      "name": "Kiribati"
    },
    {
      "code": "+965",
      "name": "Kuwait"
    },
    {
      "code": "+996",
      "name": "Kyrgyzstan"
    },
    {
      "code": "+856",
      "name": "Laos"
    },
    {
      "code": "+371",
      "name": "Latvia"
    },
    {
      "code": "+961",
      "name": "Lebanon"
    },
    {
      "code": "+266",
      "name": "Lesotho"
    },
    {
      "code": "+231",
      "name": "Liberia"
    },
    {
      "code": "+218",
      "name": "Libya"
    },
    {
      "code": "+423",
      "name": "Liechtenstein"
    },
    {
      "code": "+370",
      "name": "Lithuania"
    },
    {
      "code": "+352",
      "name": "Luxembourg"
    },
    {
      "code": "+853",
      "name": "Macau SAR China"
    },
    {
      "code": "+389",
      "name": "Macedonia"
    },
    {
      "code": "+261",
      "name": "Madagascar"
    },
    {
      "code": "+265",
      "name": "Malawi"
    },
    {
      "code": "+60",
      "name": "Malaysia"
    },
    {
      "code": "+960",
      "name": "Maldives"
    },
    {
      "code": "+223",
      "name": "Mali"
    },
    {
      "code": "+356",
      "name": "Malta"
    },
    {
      "code": "+692",
      "name": "Marshall Islands"
    },
    {
      "code": "+596",
      "name": "Martinique"
    },
    {
      "code": "+222",
      "name": "Mauritania"
    },
    {
      "code": "+230",
      "name": "Mauritius"
    },
    {
      "code": "+262",
      "name": "Mayotte"
    },
    {
      "code": "+52",
      "name": "Mexico"
    },
    {
      "code": "+691",
      "name": "Micronesia"
    },
    {
      "code": "+1 808",
      "name": "Midway Island"
    },
    {
      "code": "+373",
      "name": "Moldova"
    },
    {
      "code": "+377",
      "name": "Monaco"
    },
    {
      "code": "+976",
      "name": "Mongolia"
    },
    {
      "code": "+382",
      "name": "Montenegro"
    },
    {
      "code": "+1664",
      "name": "Montserrat"
    },
    {
      "code": "+212",
      "name": "Morocco"
    },
    {
      "code": "+95",
      "name": "Myanmar"
    },
    {
      "code": "+264",
      "name": "Namibia"
    },
    {
      "code": "+674",
      "name": "Nauru"
    },
    {
      "code": "+977",
      "name": "Nepal"
    },
    {
      "code": "+31",
      "name": "Netherlands"
    },
    {
      "code": "+599",
      "name": "Netherlands Antilles"
    },
    {
      "code": "+1 869",
      "name": "Nevis"
    },
    {
      "code": "+687",
      "name": "New Caledonia"
    },
    {
      "code": "+64",
      "name": "New Zealand"
    },
    {
      "code": "+505",
      "name": "Nicaragua"
    },
    {
      "code": "+227",
      "name": "Niger"
    },
    {
      "code": "+234",
      "name": "Nigeria"
    },
    {
      "code": "+683",
      "name": "Niue"
    },
    {
      "code": "+672",
      "name": "Norfolk Island"
    },
    {
      "code": "+850",
      "name": "North Korea"
    },
    {
      "code": "+1 670",
      "name": "Northern Mariana Islands"
    },
    {
      "code": "+47",
      "name": "Norway"
    },
    {
      "code": "+968",
      "name": "Oman"
    },
    {
      "code": "+92",
      "name": "Pakistan"
    },
    {
      "code": "+680",
      "name": "Palau"
    },
    {
      "code": "+970",
      "name": "Palestinian Territory"
    },
    {
      "code": "+507",
      "name": "Panama"
    },
    {
      "code": "+675",
      "name": "Papua New Guinea"
    },
    {
      "code": "+595",
      "name": "Paraguay"
    },
    {
      "code": "+51",
      "name": "Peru"
    },
    {
      "code": "+63",
      "name": "Philippines"
    },
    {
      "code": "+48",
      "name": "Poland"
    },
    {
      "code": "+351",
      "name": "Portugal"
    },
    {
      "code": "+1 787",
      "name": "Puerto Rico"
    },
    {
      "code": "+974",
      "name": "Qatar"
    },
    {
      "code": "+262",
      "name": "Reunion"
    },
    {
      "code": "+40",
      "name": "Romania"
    },
    {
      "code": "+7",
      "name": "Russia"
    },
    {
      "code": "+250",
      "name": "Rwanda"
    },
    {
      "code": "+685",
      "name": "Samoa"
    },
    {
      "code": "+378",
      "name": "San Marino"
    },
    {
      "code": "+966",
      "name": "Saudi Arabia"
    },
    {
      "code": "+221",
      "name": "Senegal"
    },
    {
      "code": "+381",
      "name": "Serbia"
    },
    {
      "code": "+248",
      "name": "Seychelles"
    },
    {
      "code": "+232",
      "name": "Sierra Leone"
    },
    {
      "code": "+65",
      "name": "Singapore"
    },
    {
      "code": "+421",
      "name": "Slovakia"
    },
    {
      "code": "+386",
      "name": "Slovenia"
    },
    {
      "code": "+677",
      "name": "Solomon Islands"
    },
    {
      "code": "+27",
      "name": "South Africa"
    },
    {
      "code": "+500",
      "name": "South Georgia and the South Sandwich Islands"
    },
    {
      "code": "+82",
      "name": "South Korea"
    },
    {
      "code": "+34",
      "name": "Spain"
    },
    {
      "code": "+94",
      "name": "Sri Lanka"
    },
    {
      "code": "+249",
      "name": "Sudan"
    },
    {
      "code": "+597",
      "name": "Suriname"
    },
    {
      "code": "+268",
      "name": "Swaziland"
    },
    {
      "code": "+46",
      "name": "Sweden"
    },
    {
      "code": "+41",
      "name": "Switzerland"
    },
    {
      "code": "+963",
      "name": "Syria"
    },
    {
      "code": "+886",
      "name": "Taiwan"
    },
    {
      "code": "+992",
      "name": "Tajikistan"
    },
    {
      "code": "+255",
      "name": "Tanzania"
    },
    {
      "code": "+66",
      "name": "Thailand"
    },
    {
      "code": "+670",
      "name": "Timor Leste"
    },
    {
      "code": "+228",
      "name": "Togo"
    },
    {
      "code": "+690",
      "name": "Tokelau"
    },
    {
      "code": "+676",
      "name": "Tonga"
    },
    {
      "code": "+1 868",
      "name": "Trinidad and Tobago"
    },
    {
      "code": "+216",
      "name": "Tunisia"
    },
    {
      "code": "+90",
      "name": "Turkey"
    },
    {
      "code": "+993",
      "name": "Turkmenistan"
    },
    {
      "code": "+1 649",
      "name": "Turks and Caicos Islands"
    },
    {
      "code": "+688",
      "name": "Tuvalu"
    },
    {
      "code": "+1 340",
      "name": "U.S. Virgin Islands"
    },
    {
      "code": "+256",
      "name": "Uganda"
    },
    {
      "code": "+380",
      "name": "Ukraine"
    },
    {
      "code": "+971",
      "name": "United Arab Emirates"
    },
    {
      "code": "+44",
      "name": "United Kingdom"
    },
    {
      "code": "+1",
      "name": "United States"
    },
    {
      "code": "+598",
      "name": "Uruguay"
    },
    {
      "code": "+998",
      "name": "Uzbekistan"
    },
    {
      "code": "+678",
      "name": "Vanuatu"
    },
    {
      "code": "+58",
      "name": "Venezuela"
    },
    {
      "code": "+84",
      "name": "Vietnam"
    },
    {
      "code": "+1 808",
      "name": "Wake Island"
    },
    {
      "code": "+681",
      "name": "Wallis and Futuna"
    },
    {
      "code": "+967",
      "name": "Yemen"
    },
    {
      "code": "+260",
      "name": "Zambia"
    },
    {
      "code": "+255",
      "name": "Zanzibar"
    },
    {
      "code": "+263",
      "name": "Zimbabwe"
    }
]');
            $ip =  $_SERVER['REMOTE_ADDR'];
            $json       = file_get_contents("http://ipinfo.io/{$ip}");
            $details    = json_decode($json);
            $country = $details->country;
            $code = $countryArray[$country]['code'];
            $code = str_replace('+','',$code);
            $code = '+'.$code;
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            if ($driver->basic_details == 1) {
                return redirect('driver/address');
            }
            return view('drivers.FrontEnd.basic',compact('driver','code','array'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function saveProfile(Request $request)
    {
        $input = $request->except('_token','phone');
        $reference = $this->database->getReference('user');
        $input['phone'] = $request->phone;
        $input['basic_details'] = 1;
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            driver::where('userid',Auth::user()->id)->update($input);

            $driver = driver::where('userid',Auth::user()->id)->first();
            $postData = [
                'userid' => 'driver_'.$driver->id,
                'username'=> $driver->first_name,
                'usertype'=> 'driver',
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
                ]
            ];
            $reference // this is the root reference
            ->update([
                $driver->firebase_key => $postData
            ]);

            Flash::success("Profile Saved Successfully");
            return redirect('driver/address');
        }
        Flash::error("Something went Wrong! Please try again!");
        return redirect()->back();
    }



    public function address()
    {
        if (driver::where('userid',Auth::user()->id)->exists()) {
            $countries = array("AF" => "Afghanistan",
                "AX" => "Åland Islands",
                "AL" => "Albania",
                "DZ" => "Algeria",
                "AS" => "American Samoa",
                "AD" => "Andorra",
                "AO" => "Angola",
                "AI" => "Anguilla",
                "AQ" => "Antarctica",
                "AG" => "Antigua and Barbuda",
                "AR" => "Argentina",
                "AM" => "Armenia",
                "AW" => "Aruba",
                "AU" => "Australia",
                "AT" => "Austria",
                "AZ" => "Azerbaijan",
                "BS" => "Bahamas",
                "BH" => "Bahrain",
                "BD" => "Bangladesh",
                "BB" => "Barbados",
                "BY" => "Belarus",
                "BE" => "Belgium",
                "BZ" => "Belize",
                "BJ" => "Benin",
                "BM" => "Bermuda",
                "BT" => "Bhutan",
                "BO" => "Bolivia",
                "BA" => "Bosnia and Herzegovina",
                "BW" => "Botswana",
                "BV" => "Bouvet Island",
                "BR" => "Brazil",
                "IO" => "British Indian Ocean Territory",
                "BN" => "Brunei Darussalam",
                "BG" => "Bulgaria",
                "BF" => "Burkina Faso",
                "BI" => "Burundi",
                "KH" => "Cambodia",
                "CM" => "Cameroon",
                "CA" => "Canada",
                "CV" => "Cape Verde",
                "KY" => "Cayman Islands",
                "CF" => "Central African Republic",
                "TD" => "Chad",
                "CL" => "Chile",
                "CN" => "China",
                "CX" => "Christmas Island",
                "CC" => "Cocos (Keeling) Islands",
                "CO" => "Colombia",
                "KM" => "Comoros",
                "CG" => "Congo",
                "CD" => "Congo, The Democratic Republic of The",
                "CK" => "Cook Islands",
                "CR" => "Costa Rica",
                "CI" => "Cote D'ivoire",
                "HR" => "Croatia",
                "CU" => "Cuba",
                "CY" => "Cyprus",
                "CZ" => "Czech Republic",
                "DK" => "Denmark",
                "DJ" => "Djibouti",
                "DM" => "Dominica",
                "DO" => "Dominican Republic",
                "EC" => "Ecuador",
                "EG" => "Egypt",
                "SV" => "El Salvador",
                "GQ" => "Equatorial Guinea",
                "ER" => "Eritrea",
                "EE" => "Estonia",
                "ET" => "Ethiopia",
                "FK" => "Falkland Islands (Malvinas)",
                "FO" => "Faroe Islands",
                "FJ" => "Fiji",
                "FI" => "Finland",
                "FR" => "France",
                "GF" => "French Guiana",
                "PF" => "French Polynesia",
                "TF" => "French Southern Territories",
                "GA" => "Gabon",
                "GM" => "Gambia",
                "GE" => "Georgia",
                "DE" => "Germany",
                "GH" => "Ghana",
                "GI" => "Gibraltar",
                "GR" => "Greece",
                "GL" => "Greenland",
                "GD" => "Grenada",
                "GP" => "Guadeloupe",
                "GU" => "Guam",
                "GT" => "Guatemala",
                "GG" => "Guernsey",
                "GN" => "Guinea",
                "GW" => "Guinea-bissau",
                "GY" => "Guyana",
                "HT" => "Haiti",
                "HM" => "Heard Island and Mcdonald Islands",
                "VA" => "Holy See (Vatican City State)",
                "HN" => "Honduras",
                "HK" => "Hong Kong",
                "HU" => "Hungary",
                "IS" => "Iceland",
                "IN" => "India",
                "ID" => "Indonesia",
                "IR" => "Iran, Islamic Republic of",
                "IQ" => "Iraq",
                "IE" => "Ireland",
                "IM" => "Isle of Man",
                "IL" => "Israel",
                "IT" => "Italy",
                "JM" => "Jamaica",
                "JP" => "Japan",
                "JE" => "Jersey",
                "JO" => "Jordan",
                "KZ" => "Kazakhstan",
                "KE" => "Kenya",
                "KI" => "Kiribati",
                "KP" => "Korea, Democratic People's Republic of",
                "KR" => "Korea, Republic of",
                "KW" => "Kuwait",
                "KG" => "Kyrgyzstan",
                "LA" => "Lao People's Democratic Republic",
                "LV" => "Latvia",
                "LB" => "Lebanon",
                "LS" => "Lesotho",
                "LR" => "Liberia",
                "LY" => "Libyan Arab Jamahiriya",
                "LI" => "Liechtenstein",
                "LT" => "Lithuania",
                "LU" => "Luxembourg",
                "MO" => "Macao",
                "MK" => "Macedonia, The Former Yugoslav Republic of",
                "MG" => "Madagascar",
                "MW" => "Malawi",
                "MY" => "Malaysia",
                "MV" => "Maldives",
                "ML" => "Mali",
                "MT" => "Malta",
                "MH" => "Marshall Islands",
                "MQ" => "Martinique",
                "MR" => "Mauritania",
                "MU" => "Mauritius",
                "YT" => "Mayotte",
                "MX" => "Mexico",
                "FM" => "Micronesia, Federated States of",
                "MD" => "Moldova, Republic of",
                "MC" => "Monaco",
                "MN" => "Mongolia",
                "ME" => "Montenegro",
                "MS" => "Montserrat",
                "MA" => "Morocco",
                "MZ" => "Mozambique",
                "MM" => "Myanmar",
                "NA" => "Namibia",
                "NR" => "Nauru",
                "NP" => "Nepal",
                "NL" => "Netherlands",
                "AN" => "Netherlands Antilles",
                "NC" => "New Caledonia",
                "NZ" => "New Zealand",
                "NI" => "Nicaragua",
                "NE" => "Niger",
                "NG" => "Nigeria",
                "NU" => "Niue",
                "NF" => "Norfolk Island",
                "MP" => "Northern Mariana Islands",
                "NO" => "Norway",
                "OM" => "Oman",
                "PK" => "Pakistan",
                "PW" => "Palau",
                "PS" => "Palestinian Territory, Occupied",
                "PA" => "Panama",
                "PG" => "Papua New Guinea",
                "PY" => "Paraguay",
                "PE" => "Peru",
                "PH" => "Philippines",
                "PN" => "Pitcairn",
                "PL" => "Poland",
                "PT" => "Portugal",
                "PR" => "Puerto Rico",
                "QA" => "Qatar",
                "RE" => "Reunion",
                "RO" => "Romania",
                "RU" => "Russian Federation",
                "RW" => "Rwanda",
                "SH" => "Saint Helena",
                "KN" => "Saint Kitts and Nevis",
                "LC" => "Saint Lucia",
                "PM" => "Saint Pierre and Miquelon",
                "VC" => "Saint Vincent and The Grenadines",
                "WS" => "Samoa",
                "SM" => "San Marino",
                "ST" => "Sao Tome and Principe",
                "SA" => "Saudi Arabia",
                "SN" => "Senegal",
                "RS" => "Serbia",
                "SC" => "Seychelles",
                "SL" => "Sierra Leone",
                "SG" => "Singapore",
                "SK" => "Slovakia",
                "SI" => "Slovenia",
                "SB" => "Solomon Islands",
                "SO" => "Somalia",
                "ZA" => "South Africa",
                "GS" => "South Georgia and The South Sandwich Islands",
                "ES" => "Spain",
                "LK" => "Sri Lanka",
                "SD" => "Sudan",
                "SR" => "Suriname",
                "SJ" => "Svalbard and Jan Mayen",
                "SZ" => "Swaziland",
                "SE" => "Sweden",
                "CH" => "Switzerland",
                "SY" => "Syrian Arab Republic",
                "TW" => "Taiwan, Province of China",
                "TJ" => "Tajikistan",
                "TZ" => "Tanzania, United Republic of",
                "TH" => "Thailand",
                "TL" => "Timor-leste",
                "TG" => "Togo",
                "TK" => "Tokelau",
                "TO" => "Tonga",
                "TT" => "Trinidad and Tobago",
                "TN" => "Tunisia",
                "TR" => "Turkey",
                "TM" => "Turkmenistan",
                "TC" => "Turks and Caicos Islands",
                "TV" => "Tuvalu",
                "UG" => "Uganda",
                "UA" => "Ukraine",
                "AE" => "United Arab Emirates",
                "GB" => "United Kingdom",
                "US" => "United States",
                "UM" => "United States Minor Outlying Islands",
                "UY" => "Uruguay",
                "UZ" => "Uzbekistan",
                "VU" => "Vanuatu",
                "VE" => "Venezuela",
                "VN" => "Viet Nam",
                "VG" => "Virgin Islands, British",
                "VI" => "Virgin Islands, U.S.",
                "WF" => "Wallis and Futuna",
                "EH" => "Western Sahara",
                "YE" => "Yemen",
                "ZM" => "Zambia",
                "ZW" => "Zimbabwe");
            $driver = driver::where('userid', Auth::user()->id)->first();
            if ($driver->activated != 1) {
                return redirect('driver/verify');
            } elseif ($driver->basic_details != 1) {
                return redirect('driver/profile');
            }
            if ($driver->address_details == 1) {
                return redirect('driver/verifyLicence');
            }
            $name = $driver->first_name;
            if (driverBasicDetails::where('driverid', $driver->id)->exists() == 0) {
                driverBasicDetails::create(['driverid' => $driver->id]);
            }
            $driver = driverBasicDetails::where('driverid', $driver->id)->first();
            return view('drivers.FrontEnd.address', compact('driver', 'countries', 'name'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function saveAddress(Request $request)
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $input = $request->except('_token');
            $driver = driver::where('userid',Auth::user()->id)->first();
            driverBasicDetails::where('driverid',$driver->id)->update($input);
            driver::whereId($driver->id)->update(['address_details'=>1,'city'=>$request->city]);
            Flash::success("Address saved Successfully");
            return redirect('driver/verifyLicence');
        }
        Flash::error("Something went wrong! Please try again");
        return redirect()->back();
    }


    public function verifyLicence()
    {
        if (driver::where('userid',Auth::user()->id)->exists()) {
            $driver = driver::where('userid', Auth::user()->id)->first();
            if ($driver->activated != 1) {
                return redirect('driver/verify');
            }
            elseif ($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif ($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            if ($driver->licence_details == 1)
            {
                return redirect('driver/documents');
            }
            if (driverVerification::where('driverid', $driver->id)->exists() == 0) {
                driverVerification::create(['driverid' => $driver->id]);
            }
            $cityDetails = driverBasicDetails::where('driverid',$driver->id)->first(['city']);
            $city = $cityDetails->city;
            $driver = driverVerification::where('driverid', $driver->id)->first();
            return view('drivers.FrontEnd.licence', compact('driver','city'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function SaveverifyLicence(Request $request)
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $input = $request->except('_token','date');
            $input['licence_expire'] = $request->date;
            $driver = driver::where('userid',Auth::user()->id)->first();
            driverVerification::where('driverid',$driver->id)->update($input);
            driver::whereId($driver->id)->update(['licence_details'=>1]);
            Flash::success("Licence Details saved Successfully");
            return redirect('driver/documents');
        }
        Flash::error("Something went wrong! Please try again");
        return redirect()->back();
    }


    public function documents()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid', Auth::user()->id)->first();
            $name = $driver->first_name;
            if ($driver->activated != 1) {
                return redirect('driver/verify');
            }
            elseif ($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif ($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            if ($driver->documents == 1)
            {
                return redirect('driver/agree');
            }
            if (driverVerification::where('driverid', $driver->id)->exists() == 0) {
                driverVerification::create(['driverid' => $driver->id]);
            }
            $driver = driverVerification::where('driverid', $driver->id)->first();
            return view('drivers.FrontEnd.documents', compact('driver','name'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function savedocuments(Request $request)
    {
        if ($request->hasFile('driving_licence'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->driving_licence->getClientOriginalExtension();
            $request->driving_licence->move(public_path('avatars'), $photoName);
            $input['driving_licence'] = $photoName;
        }
        if ($request->hasFile('car_insurance'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->car_insurance->getClientOriginalExtension();
            $request->car_insurance->move(public_path('avatars'), $photoName);
            $input['car_insurance'] = $photoName;
        }
        if ($request->hasFile('car_reg'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->car_reg->getClientOriginalExtension();
            $request->car_reg->move(public_path('avatars'), $photoName);
            $input['car_reg'] = $photoName;
        }
        if ($request->hasFile('car_inspection'))
        {
            $photoName = rand(1,7257361) . time() . '.' . $request->car_inspection->getClientOriginalExtension();
            $request->car_inspection->move(public_path('avatars'), $photoName);
            $input['car_inspection'] = $photoName;
        }
        if (isset($input) && count($input) > 0)
        {
            if (driver::where('userid',Auth::user()->id)->exists())
            {
                $driver = driver::where('userid',Auth::user()->id)->first();
                driverVerification::where('driverid',$driver->id)->update($input);
                driver::whereId($driver->id)->update(['documents'=>1]);
                Flash::success("Licence Details saved Successfully");
                return redirect('driver/agree');
            }
        }
        else
        {
            Flash::error("Please Select the Document to Continue");
            return redirect()->back();
        }

        Flash::error("Something went wrong! Please try again");
        return redirect()->back();
    }


    public function agree()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid', Auth::user()->id)->first();
            $name = $driver->first_name;
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif ($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif ($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            else
            {
                return view('drivers.FrontEnd.agree',compact('name','driver'));
            }
        }
    }
    public function saveAgree(Request $request)
    {
        if ($request->term != 'on' || $request->bgCheck != 'on')
        {
            Flash::error("You need to Agree to the Terms before continuing");
            return redirect()->back();
        }
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            driver::where('userid',Auth::user()->id)->update(['signature'=>$request->signature,'status'=>0]);
            Flash::success("Account Created successfully");
            return redirect('driver/SubmitDocument');
        }
        Flash::error("Something went wrong! Please try again");
        return redirect()->back();
    }


    public function SubmitDocument()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            return view('drivers.FrontEnd.ready',compact('driver'));
        }
        else
        {
            Flash::error("Something went Wrong! Please try again");
            return redirect()->back();
        }
    }

    public function home()
    {
        $driver = driver::where('userid',Auth::user()->id)->first();
        if ($driver->activated != 1)
        {
            return redirect('driver/verify');
        }
        elseif($driver->basic_details != 1)
        {
            return redirect('driver/profile');
        }
        elseif($driver->address_details != 1)
        {
            return redirect('driver/address');
        }
        elseif ($driver->licence_details != 1)
        {
            return redirect('driver/verifyLicence');
        }
        elseif ($driver->documents != 1)
        {
            return redirect('driver/documents');
        }
        elseif (empty($driver->signature) || $driver->signature == '')
        {
            return redirect('driver/agree');
        }
        elseif ($driver->status != '1')
        {
            Flash::warning("Please wait while we are verifying your Document");
            return redirect('driver/SubmitDocument');
        }
        else
        {
            if($driver->payment == 0)
            {
                return redirect('driver/payment');
            }
            $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
            $revenue = 0;
            $rides = 0;
            $distance = 0;
            if (booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(7))->exists())
            {
                $DriverBookings = booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(7))->get();
                foreach ($DriverBookings as $booking)
                {
                    $rides++;
                    $revenue = $revenue+(float)$booking->price+(float)$booking->driver_tips;
                    $distance +=(float)$booking->distance;
                }
            }
            $distance = $distance*0.621371;
            $rating = 0;
            if (rating::where('driverid',$driver->id)->whereDate('created_at','>=',Carbon::now()->subDays(7))->exists())
            {
                $rating = rating::where('driverid',$driver->id)->whereDate('created_at','>=',Carbon::now()->subDays(7))->sum('rating');
                $count = rating::where('driverid',$driver->id)->whereDate('created_at','>=',Carbon::now()->subDays(7))->count();
                $rating = ($rating*100)/($count*5);
            }
            return view('drivers.FrontEnd.home',compact('driver','driver_name','rides','revenue','distance','rating'));
        }
    }

    public function licenceDetails($id)
    {
        if (Auth::user()->status == 0)
        {
            $driver = driver::whereId($id)->first();
            $licence = driverVerification::where('driverid', $id)->first();
            return view('drivers.licenceDetails', compact('driver', 'licence'));
        }
        else
        {
            return view('errors.404');
        }
    }

    public function accept($id)
    {
        if (Auth::user()->status == 0)
        {
            driver::whereId($id)->update(['status' => 1]);
            $driver = driver::whereId($id)->first();
            $array['email'] = $driver->email;
            $array['name'] = $driver->first_name;
            $array['status'] = 1;
            Mail::send('emails.doc', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Documents are Verified");
            });
            Flash::success("Driver accepted Successfully");
            return redirect()->back();
        }
        else
        {
            return view('errors.404');
        }
    }

    public function reject($id)
    {
        if (Auth::user()->status == 0)
        {
            driver::whereId($id)->update(['status' => 2,'licence_details'=>0,'documents'=>0]);
            $driver = driver::whereId($id)->first();
            $array['email'] = $driver->email;
            $array['name'] = $driver->first_name;
            $array['status'] = 0;
            Mail::send('emails.doc', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Documents Verification Failed");
            });
            Flash::success("Driver Rejected Successfully");
            return redirect()->back();
        }
        else
        {
            return view('errors.404');
        }
    }

    public function penalty()
    {
        if (DB::table('driver_penalty')->exists())
        {
            $penalty = DB::table('driver_penalty')->first();
            $city = $penalty->city;
            $penalty = $penalty->penalty;
        }
        else
        {
            $penalty = 0;
            $city = "";
        }
        return view('drivers.penalty',compact('penalty','city'));
    }

    public function savePenalty(Request $request)
    {
        if (DB::table('driver_penalty')->exists())
        {
            DB::table('driver_penalty')->whereId(1)->update(['penalty'=>$request->penalty,'id'=>1,'city'=>$request->city]);
        }
        else
        {
            DB::table('driver_penalty')->insert(['penalty'=>$request->penalty,'id'=>1,'city'=>$request->city]);
        }
        Flash::success("Driver Penalty Updated Successfully");
        return redirect()->back();
    }

    public function changeCity($city,$code)
    {
        Session::put(''.$code.'', $city.'-'.$code);
        if ($city == 'all')
        {
            $result['code'] = 500;
            return $result;
        }
        else
        {
            $drivers = driverBasicDetails::where('city','like',$city)->get();
        }
        $result['code'] = 200;
        $result['data'] = $this->getDriverTable($drivers,$code);
        return $result;
    }

    function getDriverTable($drivers,$code)
    {
        $html = <<<EOD
        <!--<table class="table table-responsive" id="drivers-table">-->
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Licence</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
EOD;
                foreach ($drivers as $driver)
                {
                    if ($code == 0)
                    {
                        $driverDetails = driver::whereId($driver->driverid)
                                ->where('status', '!=', 1)
                                ->where('activated', 1)
                                ->where('basic_details', 1)
                                ->where('address_details', 1)
                                ->where('licence_details', 1)
                                ->where('documents', 1)
                                ->where('signature','!=',null)
                                ->first();
                    }
                    elseif ($code == 1)
                    {
                        $driverDetails = driver::whereId($driver->driverid)
                            ->where('status',1)
                            ->first();
                    }
                    else
                    {
                        $driverDetails = driver::whereId($driver->driverid)
                            ->where('status',2)
                            ->first();
                    }
                    if (!empty($driverDetails))
                    {
                        $licenceUrl = url('driver/licence') . '/' . $driverDetails->id;
                        $acceptUrl = url('driver/accept') . '/' . $driverDetails->id;
                        $rejectUrl = url('driver/reject') . '/' . $driverDetails->id;
                        $formUrl = url('driver/delete').'/'.$driverDetails->id;
                        $editUrl = route('drivers.show', $driverDetails->id);
                        $html .= <<<EOD
                    <tr>
                        <td>$driverDetails->first_name</td>
                        <td>$driverDetails->middle_name</td>
                        <td>$driverDetails->last_name</td>
                        <td>$driverDetails->email</td>
                        <td>$driverDetails->phone</td>
                    <td>
                         <a href="$licenceUrl" class="btn btn-info">Details</a>
                        <td>
EOD;
                            if ($driverDetails->status == 0)
                            {
                $html .= <<<EOD
                            <a href="$acceptUrl" class="btn btn-success btn-flat btn-xs" title="Accept the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-check" aria-hidden="true"></i></a>
                            <a href="$rejectUrl" class="btn btn-danger btn-flat btn-xs" title="Reject the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-times" aria-hidden="true"></i></a>
EOD;
                            }
                            elseif ($driverDetails->status == 2)
                            {
                $html .= <<<EOD
                            <a href="$acceptUrl" class="btn btn-success btn-flat btn-xs" title="Accept the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-check" aria-hidden="true"></i></a>
EOD;
                            }
                            else
                            {
                 $html .= <<<EOD
                            <a href="$rejectUrl" class="btn btn-danger btn-flat btn-xs" title="Reject the Driver" onclick='return confirm("Are you sure?")'><i class="fa fa-times" aria-hidden="true"></i></a>
EOD;
                            }
                $html .= <<<EOD
                        </td>
EOD;

                $html .= <<<EOD
                        <td>
                            <div class='btn-group'>
                                <a href="$editUrl" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="$formUrl" class="btn btn-danger btn-xs" onclick="return confirm('Are you Sure?')"><i class="glyphicon glyphicon-trash"></i></a>
                            </div>
                        </td>
EOD;

                    }
                }
          $html .= <<<EOD
            </tbody>
           <!--</table>-->
EOD;
    return $html;

    }

    public function delete($id)
    {
        driver::whereId($id)->delete();
        Flash::success("DriverDeleted Successfully");
        return redirect()->back();
    }

    public function changeData($value)
    {
        $driver = driver::where('userid',Auth::user()->id)->first();
        $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
        $revenue = 0;
        $rides = 0;
        $distance = 0;
        $rating = 0;
        if ($value == 1)
        {
            if (booking::where('driverid', $driver->id)->where('trip_end_time','>=', Carbon::today())->exists()) {
                $DriverBookings = booking::where('driverid', $driver->id)->where('trip_end_time', '>=', Carbon::today())->get();
                foreach ($DriverBookings as $booking) {
                    $rides++;
                    $revenue = $revenue + (float)$booking->price + (float)$booking->driver_tips;
                    $distance += (float)$booking->distance;
                }
            }
            if (rating::where('driverid', $driver->id)->where('created_at', '>=', Carbon::today())->exists()) {
                $rating = rating::where('driverid', $driver->id)->where('created_at', '>=', Carbon::today())->sum('rating');
                $count = rating::where('driverid', $driver->id)->where('created_at', '>=', Carbon::today())->count();
                $rating = ($rating*100)/($count*5);
            }
            $result['message'] = "Today's Stats";
        }
        elseif ($value == 2)
        {
            if (booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(7))->exists())
            {
                $DriverBookings = booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(7))->get();
                foreach ($DriverBookings as $booking)
                {
                    $rides++;
                    $revenue = $revenue+(float)$booking->price+(float)$booking->driver_tips;
                    $distance +=(float)$booking->distance;
                }
            }
            if (rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(7))->exists())
            {
                $rating = rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(7))->sum('rating');
                $count = rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(7))->count();
                $rating = ($rating*100)/($count*5);
            }
            $result['message'] = "Last 7 day's Stats";
        }
        elseif ($value ==3)
        {
            if (booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(30))->exists())
            {
                $DriverBookings = booking::where('driverid',$driver->id)->where('trip_end_time', '>=', Carbon::now()->subDays(30))->get();
                foreach ($DriverBookings as $booking)
                {
                    $rides++;
                    $revenue = $revenue+(float)$booking->price+(float)$booking->driver_tips;
                    $distance +=(float)$booking->distance;
                }
            }
            if (rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(30))->exists())
            {
                $rating = rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(30))->sum('rating');
                $count = rating::where('driverid',$driver->id)->where('created_at','>=',Carbon::now()->subDays(30))->count();
                $rating = ($rating*100)/($count*5);
            }
            $result['message'] = "Last 30 day's Stats";
        }
        else
        {
            if (booking::where('driverid',$driver->id)->whereYear('trip_end_time',Carbon::now()->year)->whereMonth('trip_end_time', Carbon::now()->month)->exists())
            {
                $DriverBookings = booking::where('driverid',$driver->id)->whereYear('trip_end_time',Carbon::now()->year)->whereMonth('trip_end_time', Carbon::now()->month)->get();
                foreach ($DriverBookings as $booking)
                {
                    $rides++;
                    $revenue = $revenue+(float)$booking->price+(float)$booking->driver_tips;
                    $distance +=(float)$booking->distance;
                }
            }
            if (rating::where('driverid',$driver->id)->whereYear('created_at',Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->exists())
            {
                $rating = rating::where('driverid',$driver->id)->whereYear('created_at',Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->sum('rating');
                $count = rating::where('driverid',$driver->id)->whereYear('created_at',Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
                $rating = ($rating*100)/($count*5);
            }
            $result['message'] = "This month's stats";
        }
        $distance = $distance * 0.621371;
        $result['revenue'] = '$'.number_format($revenue);
        $result['distance'] = number_format($distance,'2').' Miles';
        $result['rating'] = $rating.'%';
        $result['rides'] = number_format($rides);
        return $result;
    }
    public function editProfile()
    {
        if (Auth::user()->status == 1)
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            elseif (empty($driver->signature) || $driver->signature == '')
            {
                return redirect('driver/agree');
            }
            elseif ($driver->status != '1')
            {
                return redirect('driver/SubmitDocument');
            }
            else
            {
                if($driver->payment == 0)
                {
                    return redirect('driver/payment');
                }
                $countries = array("AF" => "Afghanistan",
                    "AX" => "Åland Islands",
                    "AL" => "Albania",
                    "DZ" => "Algeria",
                    "AS" => "American Samoa",
                    "AD" => "Andorra",
                    "AO" => "Angola",
                    "AI" => "Anguilla",
                    "AQ" => "Antarctica",
                    "AG" => "Antigua and Barbuda",
                    "AR" => "Argentina",
                    "AM" => "Armenia",
                    "AW" => "Aruba",
                    "AU" => "Australia",
                    "AT" => "Austria",
                    "AZ" => "Azerbaijan",
                    "BS" => "Bahamas",
                    "BH" => "Bahrain",
                    "BD" => "Bangladesh",
                    "BB" => "Barbados",
                    "BY" => "Belarus",
                    "BE" => "Belgium",
                    "BZ" => "Belize",
                    "BJ" => "Benin",
                    "BM" => "Bermuda",
                    "BT" => "Bhutan",
                    "BO" => "Bolivia",
                    "BA" => "Bosnia and Herzegovina",
                    "BW" => "Botswana",
                    "BV" => "Bouvet Island",
                    "BR" => "Brazil",
                    "IO" => "British Indian Ocean Territory",
                    "BN" => "Brunei Darussalam",
                    "BG" => "Bulgaria",
                    "BF" => "Burkina Faso",
                    "BI" => "Burundi",
                    "KH" => "Cambodia",
                    "CM" => "Cameroon",
                    "CA" => "Canada",
                    "CV" => "Cape Verde",
                    "KY" => "Cayman Islands",
                    "CF" => "Central African Republic",
                    "TD" => "Chad",
                    "CL" => "Chile",
                    "CN" => "China",
                    "CX" => "Christmas Island",
                    "CC" => "Cocos (Keeling) Islands",
                    "CO" => "Colombia",
                    "KM" => "Comoros",
                    "CG" => "Congo",
                    "CD" => "Congo, The Democratic Republic of The",
                    "CK" => "Cook Islands",
                    "CR" => "Costa Rica",
                    "CI" => "Cote D'ivoire",
                    "HR" => "Croatia",
                    "CU" => "Cuba",
                    "CY" => "Cyprus",
                    "CZ" => "Czech Republic",
                    "DK" => "Denmark",
                    "DJ" => "Djibouti",
                    "DM" => "Dominica",
                    "DO" => "Dominican Republic",
                    "EC" => "Ecuador",
                    "EG" => "Egypt",
                    "SV" => "El Salvador",
                    "GQ" => "Equatorial Guinea",
                    "ER" => "Eritrea",
                    "EE" => "Estonia",
                    "ET" => "Ethiopia",
                    "FK" => "Falkland Islands (Malvinas)",
                    "FO" => "Faroe Islands",
                    "FJ" => "Fiji",
                    "FI" => "Finland",
                    "FR" => "France",
                    "GF" => "French Guiana",
                    "PF" => "French Polynesia",
                    "TF" => "French Southern Territories",
                    "GA" => "Gabon",
                    "GM" => "Gambia",
                    "GE" => "Georgia",
                    "DE" => "Germany",
                    "GH" => "Ghana",
                    "GI" => "Gibraltar",
                    "GR" => "Greece",
                    "GL" => "Greenland",
                    "GD" => "Grenada",
                    "GP" => "Guadeloupe",
                    "GU" => "Guam",
                    "GT" => "Guatemala",
                    "GG" => "Guernsey",
                    "GN" => "Guinea",
                    "GW" => "Guinea-bissau",
                    "GY" => "Guyana",
                    "HT" => "Haiti",
                    "HM" => "Heard Island and Mcdonald Islands",
                    "VA" => "Holy See (Vatican City State)",
                    "HN" => "Honduras",
                    "HK" => "Hong Kong",
                    "HU" => "Hungary",
                    "IS" => "Iceland",
                    "IN" => "India",
                    "ID" => "Indonesia",
                    "IR" => "Iran, Islamic Republic of",
                    "IQ" => "Iraq",
                    "IE" => "Ireland",
                    "IM" => "Isle of Man",
                    "IL" => "Israel",
                    "IT" => "Italy",
                    "JM" => "Jamaica",
                    "JP" => "Japan",
                    "JE" => "Jersey",
                    "JO" => "Jordan",
                    "KZ" => "Kazakhstan",
                    "KE" => "Kenya",
                    "KI" => "Kiribati",
                    "KP" => "Korea, Democratic People's Republic of",
                    "KR" => "Korea, Republic of",
                    "KW" => "Kuwait",
                    "KG" => "Kyrgyzstan",
                    "LA" => "Lao People's Democratic Republic",
                    "LV" => "Latvia",
                    "LB" => "Lebanon",
                    "LS" => "Lesotho",
                    "LR" => "Liberia",
                    "LY" => "Libyan Arab Jamahiriya",
                    "LI" => "Liechtenstein",
                    "LT" => "Lithuania",
                    "LU" => "Luxembourg",
                    "MO" => "Macao",
                    "MK" => "Macedonia, The Former Yugoslav Republic of",
                    "MG" => "Madagascar",
                    "MW" => "Malawi",
                    "MY" => "Malaysia",
                    "MV" => "Maldives",
                    "ML" => "Mali",
                    "MT" => "Malta",
                    "MH" => "Marshall Islands",
                    "MQ" => "Martinique",
                    "MR" => "Mauritania",
                    "MU" => "Mauritius",
                    "YT" => "Mayotte",
                    "MX" => "Mexico",
                    "FM" => "Micronesia, Federated States of",
                    "MD" => "Moldova, Republic of",
                    "MC" => "Monaco",
                    "MN" => "Mongolia",
                    "ME" => "Montenegro",
                    "MS" => "Montserrat",
                    "MA" => "Morocco",
                    "MZ" => "Mozambique",
                    "MM" => "Myanmar",
                    "NA" => "Namibia",
                    "NR" => "Nauru",
                    "NP" => "Nepal",
                    "NL" => "Netherlands",
                    "AN" => "Netherlands Antilles",
                    "NC" => "New Caledonia",
                    "NZ" => "New Zealand",
                    "NI" => "Nicaragua",
                    "NE" => "Niger",
                    "NG" => "Nigeria",
                    "NU" => "Niue",
                    "NF" => "Norfolk Island",
                    "MP" => "Northern Mariana Islands",
                    "NO" => "Norway",
                    "OM" => "Oman",
                    "PK" => "Pakistan",
                    "PW" => "Palau",
                    "PS" => "Palestinian Territory, Occupied",
                    "PA" => "Panama",
                    "PG" => "Papua New Guinea",
                    "PY" => "Paraguay",
                    "PE" => "Peru",
                    "PH" => "Philippines",
                    "PN" => "Pitcairn",
                    "PL" => "Poland",
                    "PT" => "Portugal",
                    "PR" => "Puerto Rico",
                    "QA" => "Qatar",
                    "RE" => "Reunion",
                    "RO" => "Romania",
                    "RU" => "Russian Federation",
                    "RW" => "Rwanda",
                    "SH" => "Saint Helena",
                    "KN" => "Saint Kitts and Nevis",
                    "LC" => "Saint Lucia",
                    "PM" => "Saint Pierre and Miquelon",
                    "VC" => "Saint Vincent and The Grenadines",
                    "WS" => "Samoa",
                    "SM" => "San Marino",
                    "ST" => "Sao Tome and Principe",
                    "SA" => "Saudi Arabia",
                    "SN" => "Senegal",
                    "RS" => "Serbia",
                    "SC" => "Seychelles",
                    "SL" => "Sierra Leone",
                    "SG" => "Singapore",
                    "SK" => "Slovakia",
                    "SI" => "Slovenia",
                    "SB" => "Solomon Islands",
                    "SO" => "Somalia",
                    "ZA" => "South Africa",
                    "GS" => "South Georgia and The South Sandwich Islands",
                    "ES" => "Spain",
                    "LK" => "Sri Lanka",
                    "SD" => "Sudan",
                    "SR" => "Suriname",
                    "SJ" => "Svalbard and Jan Mayen",
                    "SZ" => "Swaziland",
                    "SE" => "Sweden",
                    "CH" => "Switzerland",
                    "SY" => "Syrian Arab Republic",
                    "TW" => "Taiwan, Province of China",
                    "TJ" => "Tajikistan",
                    "TZ" => "Tanzania, United Republic of",
                    "TH" => "Thailand",
                    "TL" => "Timor-leste",
                    "TG" => "Togo",
                    "TK" => "Tokelau",
                    "TO" => "Tonga",
                    "TT" => "Trinidad and Tobago",
                    "TN" => "Tunisia",
                    "TR" => "Turkey",
                    "TM" => "Turkmenistan",
                    "TC" => "Turks and Caicos Islands",
                    "TV" => "Tuvalu",
                    "UG" => "Uganda",
                    "UA" => "Ukraine",
                    "AE" => "United Arab Emirates",
                    "GB" => "United Kingdom",
                    "US" => "United States",
                    "UM" => "United States Minor Outlying Islands",
                    "UY" => "Uruguay",
                    "UZ" => "Uzbekistan",
                    "VU" => "Vanuatu",
                    "VE" => "Venezuela",
                    "VN" => "Viet Nam",
                    "VG" => "Virgin Islands, British",
                    "VI" => "Virgin Islands, U.S.",
                    "WF" => "Wallis and Futuna",
                    "EH" => "Western Sahara",
                    "YE" => "Yemen",
                    "ZM" => "Zambia",
                    "ZW" => "Zimbabwe");
                $array = json_decode('[
    {
      "code": "+840",
      "name": "Abkhazia"
    },
    {
      "code": "+93",
      "name": "Afghanistan"
    },
    {
      "code": "+355",
      "name": "Albania"
    },
    {
      "code": "+213",
      "name": "Algeria"
    },
    {
      "code": "+1 684",
      "name": "American Samoa"
    },
    {
      "code": "+376",
      "name": "Andorra"
    },
    {
      "code": "+244",
      "name": "Angola"
    },
    {
      "code": "+1 264",
      "name": "Anguilla"
    },
    {
      "code": "+1 268",
      "name": "Antigua and Barbuda"
    },
    {
      "code": "+54",
      "name": "Argentina"
    },
    {
      "code": "+374",
      "name": "Armenia"
    },
    {
      "code": "+297",
      "name": "Aruba"
    },
    {
      "code": "+247",
      "name": "Ascension"
    },
    {
      "code": "+61",
      "name": "Australia"
    },
    {
      "code": "+672",
      "name": "Australian External Territories"
    },
    {
      "code": "+43",
      "name": "Austria"
    },
    {
      "code": "+994",
      "name": "Azerbaijan"
    },
    {
      "code": "+1 242",
      "name": "Bahamas"
    },
    {
      "code": "+973",
      "name": "Bahrain"
    },
    {
      "code": "+880",
      "name": "Bangladesh"
    },
    {
      "code": "+1 246",
      "name": "Barbados"
    },
    {
      "code": "+1 268",
      "name": "Barbuda"
    },
    {
      "code": "+375",
      "name": "Belarus"
    },
    {
      "code": "+32",
      "name": "Belgium"
    },
    {
      "code": "+501",
      "name": "Belize"
    },
    {
      "code": "+229",
      "name": "Benin"
    },
    {
      "code": "+1 441",
      "name": "Bermuda"
    },
    {
      "code": "+975",
      "name": "Bhutan"
    },
    {
      "code": "+591",
      "name": "Bolivia"
    },
    {
      "code": "+387",
      "name": "Bosnia and Herzegovina"
    },
    {
      "code": "+267",
      "name": "Botswana"
    },
    {
      "code": "+55",
      "name": "Brazil"
    },
    {
      "code": "+246",
      "name": "British Indian Ocean Territory"
    },
    {
      "code": "+1 284",
      "name": "British Virgin Islands"
    },
    {
      "code": "+673",
      "name": "Brunei"
    },
    {
      "code": "+359",
      "name": "Bulgaria"
    },
    {
      "code": "+226",
      "name": "Burkina Faso"
    },
    {
      "code": "+257",
      "name": "Burundi"
    },
    {
      "code": "+855",
      "name": "Cambodia"
    },
    {
      "code": "+237",
      "name": "Cameroon"
    },
    {
      "code": "+1",
      "name": "Canada"
    },
    {
      "code": "+238",
      "name": "Cape Verde"
    },
    {
      "code": "+ 345",
      "name": "Cayman Islands"
    },
    {
      "code": "+236",
      "name": "Central African Republic"
    },
    {
      "code": "+235",
      "name": "Chad"
    },
    {
      "code": "+56",
      "name": "Chile"
    },
    {
      "code": "+86",
      "name": "China"
    },
    {
      "code": "+61",
      "name": "Christmas Island"
    },
    {
      "code": "+61",
      "name": "Cocos-Keeling Islands"
    },
    {
      "code": "+57",
      "name": "Colombia"
    },
    {
      "code": "+269",
      "name": "Comoros"
    },
    {
      "code": "+242",
      "name": "Congo"
    },
    {
      "code": "+243",
      "name": "Congo, Dem. Rep. of (Zaire)"
    },
    {
      "code": "+682",
      "name": "Cook Islands"
    },
    {
      "code": "+506",
      "name": "Costa Rica"
    },
    {
      "code": "+385",
      "name": "Croatia"
    },
    {
      "code": "+53",
      "name": "Cuba"
    },
    {
      "code": "+599",
      "name": "Curacao"
    },
    {
      "code": "+537",
      "name": "Cyprus"
    },
    {
      "code": "+420",
      "name": "Czech Republic"
    },
    {
      "code": "+45",
      "name": "Denmark"
    },
    {
      "code": "+246",
      "name": "Diego Garcia"
    },
    {
      "code": "+253",
      "name": "Djibouti"
    },
    {
      "code": "+1 767",
      "name": "Dominica"
    },
    {
      "code": "+1 809",
      "name": "Dominican Republic"
    },
    {
      "code": "+670",
      "name": "East Timor"
    },
    {
      "code": "+56",
      "name": "Easter Island"
    },
    {
      "code": "+593",
      "name": "Ecuador"
    },
    {
      "code": "+20",
      "name": "Egypt"
    },
    {
      "code": "+503",
      "name": "El Salvador"
    },
    {
      "code": "+240",
      "name": "Equatorial Guinea"
    },
    {
      "code": "+291",
      "name": "Eritrea"
    },
    {
      "code": "+372",
      "name": "Estonia"
    },
    {
      "code": "+251",
      "name": "Ethiopia"
    },
    {
      "code": "+500",
      "name": "Falkland Islands"
    },
    {
      "code": "+298",
      "name": "Faroe Islands"
    },
    {
      "code": "+679",
      "name": "Fiji"
    },
    {
      "code": "+358",
      "name": "Finland"
    },
    {
      "code": "+33",
      "name": "France"
    },
    {
      "code": "+596",
      "name": "French Antilles"
    },
    {
      "code": "+594",
      "name": "French Guiana"
    },
    {
      "code": "+689",
      "name": "French Polynesia"
    },
    {
      "code": "+241",
      "name": "Gabon"
    },
    {
      "code": "+220",
      "name": "Gambia"
    },
    {
      "code": "+995",
      "name": "Georgia"
    },
    {
      "code": "+49",
      "name": "Germany"
    },
    {
      "code": "+233",
      "name": "Ghana"
    },
    {
      "code": "+350",
      "name": "Gibraltar"
    },
    {
      "code": "+30",
      "name": "Greece"
    },
    {
      "code": "+299",
      "name": "Greenland"
    },
    {
      "code": "+1 473",
      "name": "Grenada"
    },
    {
      "code": "+590",
      "name": "Guadeloupe"
    },
    {
      "code": "+1 671",
      "name": "Guam"
    },
    {
      "code": "+502",
      "name": "Guatemala"
    },
    {
      "code": "+224",
      "name": "Guinea"
    },
    {
      "code": "+245",
      "name": "Guinea-Bissau"
    },
    {
      "code": "+595",
      "name": "Guyana"
    },
    {
      "code": "+509",
      "name": "Haiti"
    },
    {
      "code": "+504",
      "name": "Honduras"
    },
    {
      "code": "+852",
      "name": "Hong Kong SAR China"
    },
    {
      "code": "+36",
      "name": "Hungary"
    },
    {
      "code": "+354",
      "name": "Iceland"
    },
    {
      "code": "+91",
      "name": "India"
    },
    {
      "code": "+62",
      "name": "Indonesia"
    },
    {
      "code": "+98",
      "name": "Iran"
    },
    {
      "code": "+964",
      "name": "Iraq"
    },
    {
      "code": "+353",
      "name": "Ireland"
    },
    {
      "code": "+972",
      "name": "Israel"
    },
    {
      "code": "+39",
      "name": "Italy"
    },
    {
      "code": "+225",
      "name": "Ivory Coast"
    },
    {
      "code": "+1 876",
      "name": "Jamaica"
    },
    {
      "code": "+81",
      "name": "Japan"
    },
    {
      "code": "+962",
      "name": "Jordan"
    },
    {
      "code": "+7 7",
      "name": "Kazakhstan"
    },
    {
      "code": "+254",
      "name": "Kenya"
    },
    {
      "code": "+686",
      "name": "Kiribati"
    },
    {
      "code": "+965",
      "name": "Kuwait"
    },
    {
      "code": "+996",
      "name": "Kyrgyzstan"
    },
    {
      "code": "+856",
      "name": "Laos"
    },
    {
      "code": "+371",
      "name": "Latvia"
    },
    {
      "code": "+961",
      "name": "Lebanon"
    },
    {
      "code": "+266",
      "name": "Lesotho"
    },
    {
      "code": "+231",
      "name": "Liberia"
    },
    {
      "code": "+218",
      "name": "Libya"
    },
    {
      "code": "+423",
      "name": "Liechtenstein"
    },
    {
      "code": "+370",
      "name": "Lithuania"
    },
    {
      "code": "+352",
      "name": "Luxembourg"
    },
    {
      "code": "+853",
      "name": "Macau SAR China"
    },
    {
      "code": "+389",
      "name": "Macedonia"
    },
    {
      "code": "+261",
      "name": "Madagascar"
    },
    {
      "code": "+265",
      "name": "Malawi"
    },
    {
      "code": "+60",
      "name": "Malaysia"
    },
    {
      "code": "+960",
      "name": "Maldives"
    },
    {
      "code": "+223",
      "name": "Mali"
    },
    {
      "code": "+356",
      "name": "Malta"
    },
    {
      "code": "+692",
      "name": "Marshall Islands"
    },
    {
      "code": "+596",
      "name": "Martinique"
    },
    {
      "code": "+222",
      "name": "Mauritania"
    },
    {
      "code": "+230",
      "name": "Mauritius"
    },
    {
      "code": "+262",
      "name": "Mayotte"
    },
    {
      "code": "+52",
      "name": "Mexico"
    },
    {
      "code": "+691",
      "name": "Micronesia"
    },
    {
      "code": "+1 808",
      "name": "Midway Island"
    },
    {
      "code": "+373",
      "name": "Moldova"
    },
    {
      "code": "+377",
      "name": "Monaco"
    },
    {
      "code": "+976",
      "name": "Mongolia"
    },
    {
      "code": "+382",
      "name": "Montenegro"
    },
    {
      "code": "+1664",
      "name": "Montserrat"
    },
    {
      "code": "+212",
      "name": "Morocco"
    },
    {
      "code": "+95",
      "name": "Myanmar"
    },
    {
      "code": "+264",
      "name": "Namibia"
    },
    {
      "code": "+674",
      "name": "Nauru"
    },
    {
      "code": "+977",
      "name": "Nepal"
    },
    {
      "code": "+31",
      "name": "Netherlands"
    },
    {
      "code": "+599",
      "name": "Netherlands Antilles"
    },
    {
      "code": "+1 869",
      "name": "Nevis"
    },
    {
      "code": "+687",
      "name": "New Caledonia"
    },
    {
      "code": "+64",
      "name": "New Zealand"
    },
    {
      "code": "+505",
      "name": "Nicaragua"
    },
    {
      "code": "+227",
      "name": "Niger"
    },
    {
      "code": "+234",
      "name": "Nigeria"
    },
    {
      "code": "+683",
      "name": "Niue"
    },
    {
      "code": "+672",
      "name": "Norfolk Island"
    },
    {
      "code": "+850",
      "name": "North Korea"
    },
    {
      "code": "+1 670",
      "name": "Northern Mariana Islands"
    },
    {
      "code": "+47",
      "name": "Norway"
    },
    {
      "code": "+968",
      "name": "Oman"
    },
    {
      "code": "+92",
      "name": "Pakistan"
    },
    {
      "code": "+680",
      "name": "Palau"
    },
    {
      "code": "+970",
      "name": "Palestinian Territory"
    },
    {
      "code": "+507",
      "name": "Panama"
    },
    {
      "code": "+675",
      "name": "Papua New Guinea"
    },
    {
      "code": "+595",
      "name": "Paraguay"
    },
    {
      "code": "+51",
      "name": "Peru"
    },
    {
      "code": "+63",
      "name": "Philippines"
    },
    {
      "code": "+48",
      "name": "Poland"
    },
    {
      "code": "+351",
      "name": "Portugal"
    },
    {
      "code": "+1 787",
      "name": "Puerto Rico"
    },
    {
      "code": "+974",
      "name": "Qatar"
    },
    {
      "code": "+262",
      "name": "Reunion"
    },
    {
      "code": "+40",
      "name": "Romania"
    },
    {
      "code": "+7",
      "name": "Russia"
    },
    {
      "code": "+250",
      "name": "Rwanda"
    },
    {
      "code": "+685",
      "name": "Samoa"
    },
    {
      "code": "+378",
      "name": "San Marino"
    },
    {
      "code": "+966",
      "name": "Saudi Arabia"
    },
    {
      "code": "+221",
      "name": "Senegal"
    },
    {
      "code": "+381",
      "name": "Serbia"
    },
    {
      "code": "+248",
      "name": "Seychelles"
    },
    {
      "code": "+232",
      "name": "Sierra Leone"
    },
    {
      "code": "+65",
      "name": "Singapore"
    },
    {
      "code": "+421",
      "name": "Slovakia"
    },
    {
      "code": "+386",
      "name": "Slovenia"
    },
    {
      "code": "+677",
      "name": "Solomon Islands"
    },
    {
      "code": "+27",
      "name": "South Africa"
    },
    {
      "code": "+500",
      "name": "South Georgia and the South Sandwich Islands"
    },
    {
      "code": "+82",
      "name": "South Korea"
    },
    {
      "code": "+34",
      "name": "Spain"
    },
    {
      "code": "+94",
      "name": "Sri Lanka"
    },
    {
      "code": "+249",
      "name": "Sudan"
    },
    {
      "code": "+597",
      "name": "Suriname"
    },
    {
      "code": "+268",
      "name": "Swaziland"
    },
    {
      "code": "+46",
      "name": "Sweden"
    },
    {
      "code": "+41",
      "name": "Switzerland"
    },
    {
      "code": "+963",
      "name": "Syria"
    },
    {
      "code": "+886",
      "name": "Taiwan"
    },
    {
      "code": "+992",
      "name": "Tajikistan"
    },
    {
      "code": "+255",
      "name": "Tanzania"
    },
    {
      "code": "+66",
      "name": "Thailand"
    },
    {
      "code": "+670",
      "name": "Timor Leste"
    },
    {
      "code": "+228",
      "name": "Togo"
    },
    {
      "code": "+690",
      "name": "Tokelau"
    },
    {
      "code": "+676",
      "name": "Tonga"
    },
    {
      "code": "+1 868",
      "name": "Trinidad and Tobago"
    },
    {
      "code": "+216",
      "name": "Tunisia"
    },
    {
      "code": "+90",
      "name": "Turkey"
    },
    {
      "code": "+993",
      "name": "Turkmenistan"
    },
    {
      "code": "+1 649",
      "name": "Turks and Caicos Islands"
    },
    {
      "code": "+688",
      "name": "Tuvalu"
    },
    {
      "code": "+1 340",
      "name": "U.S. Virgin Islands"
    },
    {
      "code": "+256",
      "name": "Uganda"
    },
    {
      "code": "+380",
      "name": "Ukraine"
    },
    {
      "code": "+971",
      "name": "United Arab Emirates"
    },
    {
      "code": "+44",
      "name": "United Kingdom"
    },
    {
      "code": "+1",
      "name": "United States"
    },
    {
      "code": "+598",
      "name": "Uruguay"
    },
    {
      "code": "+998",
      "name": "Uzbekistan"
    },
    {
      "code": "+678",
      "name": "Vanuatu"
    },
    {
      "code": "+58",
      "name": "Venezuela"
    },
    {
      "code": "+84",
      "name": "Vietnam"
    },
    {
      "code": "+1 808",
      "name": "Wake Island"
    },
    {
      "code": "+681",
      "name": "Wallis and Futuna"
    },
    {
      "code": "+967",
      "name": "Yemen"
    },
    {
      "code": "+260",
      "name": "Zambia"
    },
    {
      "code": "+255",
      "name": "Zanzibar"
    },
    {
      "code": "+263",
      "name": "Zimbabwe"
    }
]');
                $code = $driver->code;
                $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
                $phone = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $driver->phone);
                $address = driverBasicDetails::where('driverid',$driver->id)->first();
                return view('drivers.FrontEnd.edit',compact('driver','driver_name','address','code','array','phone','countries'));
            }
        }
        else
        {
            return redirect('home');
        }
    }



    public function history()
    {
        if (Auth::user()->status == 1)
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            elseif (empty($driver->signature) || $driver->signature == '')
            {
                return redirect('driver/agree');
            }
            elseif ($driver->status != '1')
            {
                return redirect('driver/SubmitDocument');
            }
            else
            {
                if($driver->payment == 0)
                {
                    return redirect('driver/payment');
                }
                if($from = Session::get('fromDate') && $to = Session::get('toDate'))
                {
                    $from = Session::get('fromDate');
                    $to = Session::get('toDate');
                    if ($from == $to)
                    {
                        $rides = booking::where('driverid',$driver->id)->where('trip_start_time','!=',null)->whereDate('trip_end_time',$from)->paginate(3);
                    }
                    else
                    {
                        $rides = booking::where('driverid',$driver->id)->where('trip_start_time','!=',null)->whereDate('trip_end_time','>=',$from)->whereDate('trip_end_time','<=',$to)->paginate(3);
                    }
                }
                else
                {
                    Session::put('fromDate',date('Y-m-d'.' 00:00:00',time()));
                    Session::put('toDate',date('Y-m-d'.' 24:60:60',time()));
                    $rides = booking::where('driverid',$driver->id)->where('trip_start_time','!=',null)->whereDate('trip_end_time',Carbon::today())->paginate(3);
                }
                $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
                return view('drivers.FrontEnd.history',compact('driver','driver_name','rides'));
            }
        }
        else
        {
            return redirect('home');
        }
    }



    public function SaveeditProfile(Request $request)
    {
        $input = $request->except('_token','image','type');
        if ($request->type == 1)
        {
            $driver = driverBasicDetails::where('driverid',$request->driverid)->update($input);
            driver::whereId($request->driverid)->update(['city'=>$request->city]);
            return $driver;
        }
        elseif ($request->type == 2)
        {
            if ($request->hasFile('image'))
            {
                $driverDetails = driver::whereId($request->driverid)->first();
                $filepath2 = public_path('avatars'.'/'.$driverDetails->image);
                $filepath1 = public_path('avatars' . '/' . $request->image);
                $this->UnlinkImage($filepath1,$filepath2);
                $photoName = rand(1,7257361) . time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('avatars'), $photoName);
                $driver = driver::whereId($request->driverid)->update(['image'=>$photoName]);
            }
            return $driver;
        }
        elseif ($request->type == 3)
        {
            if (User::where('id','!=',Auth::user()->id)->where('email',$request->email)->exists() || driver::where('id','!=',$request->driverid)->where('email',$request->email)->exists())
            {
                return 2;
            }
            else
            {
                $driver = driver::whereId($request->driverid)->update(['new_email'=>$request->email]);
                $array['email'] = $request->email;
                $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
                $array['otp'] = $email_otp;
                Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Verify Email");
                });
                $input1['email_otp'] = $email_otp;
                driver::whereId($request->driverid)->update($input1);
                return $driver;
            }
        }
        else
        {
            $driver = driver::whereId($request->driverid)->update(['code'=>$request->code,'phone'=>$request->phone]);
            return $driver;
        }
    }

    public function upcoming()
    {
        if (Auth::user()->status == 1)
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            elseif (empty($driver->signature) || $driver->signature == '')
            {
                return redirect('driver/agree');
            }
            elseif ($driver->status != '1')
            {
                return redirect('driver/SubmitDocument');
            }
            else
            {
                if($driver->payment == 0)
                {
                    return redirect('driver/payment');
                }
                $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
                $documents = driverVerification::where('driverid',$driver->id)->first();
                return view('drivers.FrontEnd.upcoming',compact('driver','driver_name','documents'));
            }
        }
        else
        {
            return redirect('home');
        }
    }

    public function saveUpcoming(Request $request)
    {
        if ($request->hasFile('car_inspection'))
        {
            $driverDetails = driver::whereId($request->driverid)->first();
            $driverVerification = driverVerification::where('driverid',$request->driverid)->first();
            $filepath2 = public_path('avatars'.'/'.$driverVerification->car_inspection);
            $filepath1 = public_path('avatars' . '/' . $request->car_inspection);
            $this->UnlinkImage($filepath1,$filepath2);
            $photoName = rand(1,7257361) . time() . '.' . $request->car_inspection->getClientOriginalExtension();
            $request->car_inspection->move(public_path('avatars'), $photoName);
            $driver = driverVerification::where('driverid',$request->driverid)->update(['car_inspection'=>$photoName]);
            if($driverDetails->status == 1)
            {
                $array['name'] = $driverDetails->first_name;
                $array['email'] = "nishanth.bajarngisoft@gmail.com";
                $array['id'] = $driverDetails->id;
                Mail::send('emails.docChange', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Documents Updated");
                });
            }
            driver::whereId($driverDetails->id)->update(['status'=>0]);
            return $driver;
        }
        elseif($request->hasFile('car_insurance'))
        {
            $driverDetails = driver::whereId($request->driverid)->first();
            $driverVerification = driverVerification::where('driverid',$request->driverid)->first();
            $filepath2 = public_path('avatars'.'/'.$driverVerification->car_insurance);
            $filepath1 = public_path('avatars' . '/' . $request->car_insurance);
            $this->UnlinkImage($filepath1,$filepath2);
            $photoName = rand(1,7257361) . time() . '.' . $request->car_insurance->getClientOriginalExtension();
            $request->car_insurance->move(public_path('avatars'), $photoName);
            $driver = driverVerification::where('driverid',$request->driverid)->update(['car_insurance'=>$photoName]);
            if($driverDetails->status == 1)
            {
                $array['name'] = $driverDetails->first_name;
                $array['email'] = "nishanth.bajarngisoft@gmail.com";
                $array['id'] = $driverDetails->id;
                Mail::send('emails.docChange', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Documents Updated");
                });
            }
            driver::whereId($driverDetails->id)->update(['status'=>0]);
            return $driver;
        }
        elseif($request->hasFile('car_reg'))
        {
            $driverDetails = driver::whereId($request->driverid)->first();
            $driverVerification = driverVerification::where('driverid',$request->driverid)->first();
            $filepath2 = public_path('avatars'.'/'.$driverVerification->car_reg);
            $filepath1 = public_path('avatars' . '/' . $request->car_reg);
            $this->UnlinkImage($filepath1,$filepath2);
            $photoName = rand(1,7257361) . time() . '.' . $request->car_reg->getClientOriginalExtension();
            $request->car_reg->move(public_path('avatars'), $photoName);
            $driver = driverVerification::where('driverid',$request->driverid)->update(['car_reg'=>$photoName]);
            if($driverDetails->status == 1)
            {
                $array['name'] = $driverDetails->first_name;
                $array['email'] = "nishanth.bajarngisoft@gmail.com";
                $array['id'] = $driverDetails->id;
                Mail::send('emails.docChange', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Documents Updated");
                });
            }
            driver::whereId($driverDetails->id)->update(['status'=>0]);
            return $driver;
        }
        elseif($request->hasFile('driving_licence'))
        {
            $driverDetails = driver::whereId($request->driverid)->first();
            $driverVerification = driverVerification::where('driverid',$request->driverid)->first();
            $filepath2 = public_path('avatars'.'/'.$driverVerification->driving_licence);
            $filepath1 = public_path('avatars' . '/' . $request->driving_licence);
            $this->UnlinkImage($filepath1,$filepath2);
            $photoName = rand(1,7257361) . time() . '.' . $request->driving_licence->getClientOriginalExtension();
            $request->driving_licence->move(public_path('avatars'), $photoName);
            $driver = driverVerification::where('driverid',$request->driverid)->update(['driving_licence'=>$photoName]);
            if($driverDetails->status == 1)
            {
                $array['name'] = $driverDetails->first_name;
                $array['email'] = "nishanth.bajarngisoft@gmail.com";
                $array['id'] = $driverDetails->id;
                Mail::send('emails.docChange', ['array' => $array], function ($message) use ($array) {
                    $message->to($array['email'])->subject("Documents Updated");
                });
            }
            driver::whereId($driverDetails->id)->update(['status'=>0]);
            return $driver;
        }
        else
        {
            return 0;
        }
    }

    public function account()
    {
        if (Auth::user()->status == 1)
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            elseif($driver->basic_details != 1)
            {
                return redirect('driver/profile');
            }
            elseif($driver->address_details != 1)
            {
                return redirect('driver/address');
            }
            elseif ($driver->licence_details != 1)
            {
                return redirect('driver/verifyLicence');
            }
            elseif ($driver->documents != 1)
            {
                return redirect('driver/documents');
            }
            elseif (empty($driver->signature) || $driver->signature == '')
            {
                return redirect('driver/agree');
            }
            elseif ($driver->status != '1')
            {
                return redirect('driver/SubmitDocument');
            }
            else
            {
                if($driver->payment == 0)
                {
                    return redirect('driver/payment');
                }
//                $date = new \DateTime();
//                $date->add(new \DateInterval('P1M'));
//                return $date->format('d/m/Y H:i:s');
                $driverPay = driverPaymentHistory::where('driverid',$driver->id)->get();
                $DriverCategory = driverCategory::where('driverid',$driver->id)->first();
                $subscription = driverSubscription::where('city','like',$driver->city)->where('category',$DriverCategory->categoryid)->first();
                $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
                $cards = driverStripe::where('driverid',$driver->id)->first();
                $histories = driverPaymentHistory::where('driverid',$driver->id)->get();
                return view('drivers.FrontEnd.account',compact('driver','driver_name','cards','subscription','histories'));
            }
        }
        else
        {
            return redirect('home');
        }
    }

    public function fromToDate($from,$to,$driverid)
    {
//        return $driverid;
        $from = strtotime(str_replace('-','/',$from));
        $to = strtotime(str_replace('-','/',$to));
        $from = date('Y-m-d' . ' 00:00:00', $from); //need a space after dates.
        $to = date('Y-m-d' . ' 24:60:60', $to);
        Session::put('fromDate',$from);
        Session::put('toDate',$to);
       return "success";
    }
    function getAddress($lat,$lon)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&key=AIzaSyB56Xh1A7HQDPQg_7HxrPTcSNnlpqYavc0";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        return $response_a['results'][0]['formatted_address'];
    }
    function UnlinkImage($filepath1,$filepath2)
    {
        $old_image = $filepath2;
        $new_image = $filepath1;
        if (file_exists($old_image)) {
            @unlink($old_image);
        }
        if (file_exists($new_image)) {
            @unlink($new_image);
        }
    }

    public function payment()
    {
        $driver = driver::where('userid',Auth::user()->id)->first();
        $DriverCategory = driverCategory::where('driverid',$driver->id)->first();
        $subscription = driverSubscription::where('city','like',$driver->city)->where('category',$DriverCategory)->first();
        $driver_name = $driver->first_name.' '.$driver->middle_name.' '.$driver->last_name;
        return view('drivers.FrontEnd.payment',compact('driver_name','driver','subscription'));
    }

    public function payWithStripe(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $driver = driver::where('userid', Auth::user()->id)->first();
        if (empty($driver->stripeid)) {
            $customer = $stripe->customers()->create([
                'email' => $driver->email,
            ]);
            $customerId = $customer['id'];
            driver::whereId($driver->id)->update(['stripeid' => $customerId]);
        } else {
            $customerId = $driver->stripeid;
        }
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->get('card_no'),
                    'exp_month' => $request->get('ccExpiryMonth'),
                    'exp_year' => $request->get('ccExpiryYear'),
                    'cvc' => $request->get('cvvNumber'),
                ],
            ]);
        } catch (\Exception $e) {
            $response['code'] = 0;
            $response['message'] = $e->getMessage();
            return $response;
        }
        if(driverStripe::where('driverid',$driver->id)->where('fingerprint',$token['card']['fingerprint'])->exists() == 0)
        {
            if (driverStripe::where('driverid',$driver->id)->exists())
            {
                $oldCard = driverStripe::where('driverid',$driver->id)->first();
                $stripe->cards()->delete($customerId, $oldCard->cardNo);
                driverStripe::whereId($oldCard->id)->forcedelete();
            }
            $card = $stripe->cards()->create($customerId, $token['id']);
            $input['driverid'] = $driver->id;
            $input['cardNo'] = $card['id'];
            $input['fingerprint'] = $card['fingerprint'];
            $input['status'] = 1;
            $input['customerId'] = $customerId;
            $input['brand'] = $card['brand'];
            $input['digits'] = '************'.$card['last4'];
            driverStripe::create($input);
        }
        else
        {
            $response['code'] = 2;
            $response['message'] = "Card already Exists";
            return $response;
        }
        $DriverCategory = driverCategory::where('driverid',$driver->id)->first();
        $driverPlans = driverSubscription::where('city','like',$driver->city)->where('category',$DriverCategory)->first();
        $subscription = $stripe->subscriptions()->create($customerId, [
            'plan' => $driverPlans->stripe_id,
        ]);
        if ($subscription['status'] == 'active')
        {
            $time = strtotime('+30 days');
            driverPaymentHistory::create(['driverid'=>$driver->id,'amount'=>$driverPlans->amount,'stripe_sub'=>$subscription['id']]);
            driver::whereId($driver->id)->update(['payment'=>1,'next_pay'=>$time]);
            Flash::success("Payment Successfull");
            $response['code'] = 1;
            $response['message'] = "Payment Successfull";
            return $response;
        }
        else
        {
            $response['code'] = 0;
            $response['message'] = "Could not complete the Payment";
            return $response;
        }
    }

    public function verifyChangeEmail(Request $request)
    {
        if(driver::whereId($request->driverid)->where('new_email',$request->email)->where('email_otp',$request->otp)->exists())
        {
            driver::whereId($request->driverid)->update(['email'=>$request->email]);
            User::whereId(Auth::user()->id)->update(['email'=>$request->email]);
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function resentEmailOtp(Request $request)
    {
        $array['email'] = $request->email;
        $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
        $array['otp'] = $email_otp;
        Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
            $message->to($array['email'])->subject("Verify Email");
        });
        $input['email_otp'] = $email_otp;
        $driver=driver::where('userid',Auth::user()->id)->update($input);
        return $driver;
    }

    public function changeCardDetails(Request $request)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $driver = driver::where('userid',Auth::user()->id)->first();
        if (empty($driver->stripeid))
        {
            $customer = $stripe->customers()->create([
                'email' => $driver->email,
            ]);
            $customerId = $customer['id'];
            driver::whereId($driver->id)->update(['stripeid'=>$customerId]);
        }
        else
        {
            $customerId = $driver->stripeid;
        }
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->get('card_no'),
                    'exp_month' => $request->get('ccExpiryMonth'),
                    'exp_year' => $request->get('ccExpiryYear'),
                    'cvc' => $request->get('cvvNumber'),
                ],
            ]);
        } catch (\Exception $e) {
            $response['code'] = 0;
            $response['message'] = $e->getMessage();
            return $response;
        }
        if(driverStripe::where('driverid',$driver->id)->where('fingerprint',$token['card']['fingerprint'])->exists() == 0)
        {
            if (driverStripe::where('driverid',$driver->id)->exists())
            {
                $oldCard = driverStripe::where('driverid',$driver->id)->first();
                $stripe->cards()->delete($customerId, $oldCard->cardNo);
                driverStripe::whereId($oldCard->id)->forcedelete();
            }
            $card = $stripe->cards()->create($customerId, $token['id']);
            $input['driverid'] = $driver->id;
            $input['cardNo'] = $card['id'];
            $input['fingerprint'] = $card['fingerprint'];
            $input['status'] = 1;
            $input['customerId'] = $customerId;
            $input['brand'] = $card['brand'];
            $input['digits'] = '************'.$card['last4'];
            driverStripe::create($input);
            $response['code'] = 1;
            $response['card'] = $input['digits'];
            $response['message'] = "Card saved Successfully";
            return $response;
        }
        else
        {
            $response['code'] = 2;
            $response['message'] = "Card already Exists";
            return $response;
        }
    }
}
