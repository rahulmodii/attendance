<?php

namespace App\Livewire;

use App\Models\Settings;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class Login extends Component
{

    public $mobile;
    public $country_code = 91;
    public $otp;
    public $isSent = false;

    public $isNewUser = false;
    public $referral_code;
    public $countryList = [];

    public function mount()
    {

        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $this->countryList = [
            "91" => "India",
            "93" => "Afghanistan",
            "355" => "Albania",
            "213" => "Algeria",
            "1" => "American Samoa",
            "376" => "Andorra",
            "244" => "Angola",
            "1" => "Anguilla",
            "672" => "Antarctica",
            "1" => "Antigua and Barbuda",
            "54" => "Argentina",
            "374" => "Armenia",
            "297" => "Aruba",
            "61" => "Australia",
            "43" => "Austria",
            "994" => "Azerbaijan",
            "1" => "Bahamas",
            "973" => "Bahrain",
            "880" => "Bangladesh",
            "1" => "Barbados",
            "375" => "Belarus",
            "32" => "Belgium",
            "501" => "Belize",
            "229" => "Benin",
            "1" => "Bermuda",
            "975" => "Bhutan",
            "591" => "Bolivia",
            "387" => "Bosnia and Herzegovina",
            "267" => "Botswana",
            "55" => "Brazil",
            "246" => "British Indian Ocean Territory",
            "673" => "Brunei",
            "359" => "Bulgaria",
            "226" => "Burkina Faso",
            "257" => "Burundi",
            "855" => "Cambodia",
            "237" => "Cameroon",
            "1" => "Canada",
            "238" => "Cape Verde",
            "1" => "Cayman Islands",
            "236" => "Central African Republic",
            "235" => "Chad",
            "56" => "Chile",
            "86" => "China",
            "61" => "Christmas Island",
            "61" => "Cocos Islands",
            "57" => "Colombia",
            "269" => "Comoros",
            "682" => "Cook Islands",
            "506" => "Costa Rica",
            "385" => "Croatia",
            "53" => "Cuba",
            "599" => "Curacao",
            "357" => "Cyprus",
            "420" => "Czech Republic",
            "243" => "Democratic Republic of the Congo",
            "45" => "Denmark",
            "253" => "Djibouti",
            "1" => "Dominica",
            "1" => "Dominican Republic",
            "1" => "Dominican Republic",
            "1" => "Dominican Republic",
            "593" => "Ecuador",
            "20" => "Egypt",
            "503" => "El Salvador",
            "240" => "Equatorial Guinea",
            "291" => "Eritrea",
            "372" => "Estonia",
            "251" => "Ethiopia",
            "500" => "Falkland Islands",
            "298" => "Faroe Islands",
            "679" => "Fiji",
            "358" => "Finland",
            "33" => "France",
            "594" => "French Guiana",
            "689" => "French Polynesia",
            "241" => "Gabon",
            "220" => "Gambia",
            "995" => "Georgia",
            "49" => "Germany",
            "233" => "Ghana",
            "350" => "Gibraltar",
            "30" => "Greece",
            "299" => "Greenland",
            "1" => "Grenada",
            "590" => "Guadeloupe",
            "1" => "Guam",
            "502" => "Guatemala",
            "44" => "Guernsey",
            "224" => "Guinea",
            "245" => "Guinea-Bissau",
            "592" => "Guyana",
            "509" => "Haiti",
            "504" => "Honduras",
            "852" => "Hong Kong",
            "36" => "Hungary",
            "354" => "Iceland",
            "62" => "Indonesia",
            "98" => "Iran",
            "964" => "Iraq",
            "353" => "Ireland",
            "44" => "Isle of Man",
            "972" => "Israel",
            "39" => "Italy",
            "225" => "Ivory Coast",
            "1" => "Jamaica",
            "81" => "Japan",
            "44" => "Jersey",
            "962" => "Jordan",
            "7" => "Kazakhstan",
            "254" => "Kenya",
            "686" => "Kiribati",
            "383" => "Kosovo",
            "965" => "Kuwait",
            "996" => "Kyrgyzstan",
            "856" => "Laos",
            "371" => "Latvia",
            "961" => "Lebanon",
            "266" => "Lesotho",
            "231" => "Liberia",
            "218" => "Libya",
            "423" => "Liechtenstein",
            "370" => "Lithuania",
            "352" => "Luxembourg",
            "853" => "Macau",
            "389" => "Macedonia",
            "261" => "Madagascar",
            "265" => "Malawi",
            "60" => "Malaysia",
            "960" => "Maldives",
            "223" => "Mali",
            "356" => "Malta",
            "692" => "Marshall Islands",
            "596" => "Martinique",
            "222" => "Mauritania",
            "230" => "Mauritius",
            "262" => "Mayotte",
            "52" => "Mexico",
            "691" => "Micronesia",
            "373" => "Moldova",
            "377" => "Monaco",
            "976" => "Mongolia",
            "382" => "Montenegro",
            "1" => "Montserrat",
            "212" => "Morocco",
            "258" => "Mozambique",
            "95" => "Myanmar",
            "264" => "Namibia",
            "674" => "Nauru",
            "977" => "Nepal",
            "31" => "Netherlands",
            "599" => "Netherlands Antilles",
            "687" => "New Caledonia",
            "64" => "New Zealand",
            "505" => "Nicaragua",
            "227" => "Niger",
            "234" => "Nigeria",
            "683" => "Niue",
            "672" => "Norfolk Island",
            "850" => "North Korea",
            "1" => "Northern Mariana Islands",
            "47" => "Norway",
            "968" => "Oman",
            "92" => "Pakistan",
            "680" => "Palau",
            "970" => "Palestine",
            "507" => "Panama",
            "675" => "Papua New Guinea",
            "595" => "Paraguay",
            "51" => "Peru",
            "63" => "Philippines",
            "48" => "Poland",
            "351" => "Portugal",
            "1" => "Puerto Rico",
            "1" => "Puerto Rico",
            "974" => "Qatar",
            "242" => "Republic of the Congo",
            "262" => "Reunion",
            "40" => "Romania",
            "7" => "Russia",
            "250" => "Rwanda",
            "590" => "Saint Barthelemy",
            "290" => "Saint Helena",
            "1" => "Saint Kitts and Nevis",
            "1" => "Saint Lucia",
            "590" => "Saint Martin",
            "508" => "Saint Pierre and Miquelon",
            "1" => "Saint Vincent and the Grenadines",
            "685" => "Samoa",
            "378" => "San Marino",
            "239" => "Sao Tome and Principe",
            "966" => "Saudi Arabia",
            "221" => "Senegal",
            "381" => "Serbia",
            "248" => "Seychelles",
            "232" => "Sierra Leone",
            "65" => "Singapore",
            "1" => "Sint Maarten",
            "421" => "Slovakia",
            "386" => "Slovenia",
            "677" => "Solomon Islands",
            "252" => "Somalia",
            "27" => "South Africa",
            "82" => "South Korea",
            "211" => "South Sudan",
            "34" => "Spain",
            "94" => "Sri Lanka",
            "249" => "Sudan",
            "597" => "Suriname",
            "47" => "Svalbard and Jan Mayen",
            "268" => "Swaziland",
            "46" => "Sweden",
            "41" => "Switzerland",
            "963" => "Syria",
            "886" => "Taiwan",
            "992" => "Tajikistan",
            "255" => "Tanzania",
            "66" => "Thailand",
            "670" => "Timor-Leste",
            "228" => "Togo",
            "690" => "Tokelau",
            "676" => "Tonga",
            "1" => "Trinidad and Tobago",
            "216" => "Tunisia",
            "90" => "Turkey",
            "993" => "Turkmenistan",
            "1" => "Turks and Caicos Islands",
            "688" => "Tuvalu",
            "256" => "Uganda",
            "380" => "Ukraine",
            "971" => "United Arab Emirates",
            "44" => "United Kingdom",
            "1" => "United States",
            "598" => "Uruguay",
            "998" => "Uzbekistan",
            "678" => "Vanuatu",
            "379" => "Vatican",
            "58" => "Venezuela",
            "84" => "Vietnam",
            "1" => "British Virgin Islands",
            "1" => "United States Virgin Islands",
            "681" => "Wallis and Futuna",
            "212" => "Western Sahara",
            "967" => "Yemen",
            "260" => "Zambia",
            "263" => "Zimbabwe",
        ];

        $this->referral_code = request()->query('referal');
    }

    public function sendOtp()
    {
        if ($this->isNewUser) {
            $this->validate([
                'referral_code' => 'required',
            ]);
        }

        if ($this->isSent) {
            $checkVerification = Verification::where(['mobile' => $this->mobile, 'otp' => $this->otp, 'country_code' => $this->country_code])->first();
            if ($checkVerification) {
                $checkVerification->delete();
                $preCheckUser = User::where(['mobile' => $this->mobile, 'country_code' => $this->country_code])->first();
                if ($preCheckUser) {
                    Auth::login($preCheckUser, true);
                    $id = Auth::user()->id;
                    if (auth()->user()->role == 1) {
                        $checkSettings = Settings::where('user_id', $id)->first();
                        if (!$checkSettings) {
                            return redirect()->route('settings');
                        }
                    }

                    return redirect()->route('attendance');
                } else {
                    $referId = User::where(['mobile' => $this->referral_code])->first();
                    if ($referId) {
                        $auth = User::create(['name' => Str::random(8), 'email' => "$this->country_code $this->mobile@mailsac.com", 'mobile' => $this->mobile, 'password' => Hash::make($this->mobile), 'role' => 1, 'country_code' => $this->country_code, 'referal_id' => $referId->id]);
                        Auth::login($auth, true);
                        $id = Auth::user()->id;
                        if (auth()->user()->role == 1) {
                            $checkSettings = Settings::where('user_id', $id)->first();
                            if (!$checkSettings) {
                                return redirect()->route('settings');
                            }
                        }
                        return redirect()->route('attendance');
                    }else{
                        return $this->dispatch('message', 'Invalid Referal Code');
                    }

                }
            } else {
                return $this->dispatch('message', 'Wrong Otp');
            }
        } else {
            $localotp = rand(1000, 9999);
            $mobile = "$this->country_code $this->mobile";
            // $this->otp = $localotp;
            Verification::where(['mobile' => $this->mobile, 'country_code' => $this->country_code])->delete();
            Verification::create(['mobile' => $this->mobile, 'otp' => $localotp, 'country_code' => $this->country_code]);
            $url = 'https://webhooks.wappblaster.com/webhook/669b736a97d275a0b8012769';
            $response = Http::get($url, [
                'number' => $mobile,
                'otp' => $localotp,
            ]);
            $this->isSent = true;
            $check = User::where(['mobile' => $this->mobile, 'country_code' => $this->country_code])->first();
            if (!$check) {
                $this->isNewUser = true;
            }
        }

    }

    public function render()
    {
        return view('livewire.login');
    }
}
