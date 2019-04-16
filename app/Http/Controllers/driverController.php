<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatedriverRequest;
use App\Http\Requests\UpdatedriverRequest;
use App\Models\driver;
use App\Models\driverBasicDetails;
use App\Models\driverVerification;
use App\Repositories\driverRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class driverController extends Controller
{
    /** @var  driverRepository */
    private $driverRepository;
    protected $sid    = "AC7835895b4de3218265df779b550d793b";
    protected $token  = "c44245d2f7d682f18eb3a1399d8d5ef6";

    public function __construct(driverRepository $driverRepo)
    {
        $this->middleware('auth');
        $this->driverRepository = $driverRepo;
    }

    /**
     * Display a listing of the driver.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->driverRepository->pushCriteria(new RequestCriteria($request));
        $drivers = $this->driverRepository->all();

        return view('drivers.index')
            ->with('drivers', $drivers);
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

        $this->driverRepository->delete($id);

        Flash::success('Driver deleted successfully.');

        return redirect(route('drivers.index'));
    }
    public function verification()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
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
            $phone_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $email_otp = substr(str_shuffle("012345678901234567890123456789"), 0, 6);
            $array['email'] = $driver->email;
            $array['otp'] = $email_otp;
            $array['phone'] = $driver->phone;
            $input['email_otp'] = $email_otp;
            $input['phone_otp'] = $phone_otp;
            Mail::send('emails.verify', ['array' => $array], function ($message) use ($array) {
                $message->to($array['email'])->subject("Verify Email");
            });
            $response=app('App\Http\Controllers\api\Controller')->sendOtp($this->sid,$this->token,$array['phone'],$phone_otp);
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
        if (driver::whereId($request->driverid)->where('phone',$request->phone)->where('email',$request->email)->where('phone_otp',$request->phone_otp)->where('email_otp',$request->email_otp)->exists())
        {
            driver::whereId($request->driverid)->update(['activated'=>1]);
            Flash::success("Phone and Email Verified Successfully");
            return redirect('home');
        }
        Flash::error("Phone and Email Verification Failed");
        return redirect()->back();
    }
    public function profile()
    {
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            $driver = driver::where('userid',Auth::user()->id)->first();
            if ($driver->activated != 1)
            {
                return redirect('driver/verify');
            }
            return view('drivers.FrontEnd.basic',compact('driver'));
        }
        else
        {
            return redirect()->back();
        }
    }
    public function saveProfile(Request $request)
    {
        $input = $request->except('_token');
        $input['basic_details'] = 1;
        if (driver::where('userid',Auth::user()->id)->exists())
        {
            driver::where('userid',Auth::user()->id)->update($input);
            Flash::success("Profile Saved Successfully");
            return redirect('home');
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
            driver::whereId($driver->id)->update(['address_details'=>1]);
            Flash::success("Address saved Successfully");
            return redirect('home');
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
            return redirect('home');
        }
        Flash::error("Something went wrong! Please try again");
        return redirect()->back();
    }
    public function documents()
    {
        if (driver::where('userid',Auth::user()->id)->exists()) {
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
}
