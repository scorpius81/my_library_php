<?php



namespace gsensale\App;

use \PalePurple\RateLimit\RateLimit;
use \PalePurple\RateLimit\Adapter\Redis as RedisAdapter;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

class Utils {

    public $redis_host;
    public $redis_port;
    public $redis_pass;
    public $RateLimitMaxRequest;
    public $RateLimitRequestTime;
    public $RateLimitIPCheck;


    public function __construct()
    {
        $this->redis_host='127.0.0.1';
        $this->redis_port='6379';
        $this->redis_pass='';

        if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
        $this->RateLimitIPCheck = $_SERVER['REMOTE_ADDR']; // Use client IP as identity
        $this->RateLimitMaxRequest= 100;
        $this->RateLimitRequestTime= 3600;
    }
    public function getSgilaNazioneFromNome($nomeNazione){
        $nazioni_it = array(
            'AF' => 'Afghanistan',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antartide',
            'AG' => 'Antigua e Barbuda',
            'AN' => 'Antille Olandesi',
            'SA' => 'Arabia Saudita',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaigian',
            'BS' => 'Bahamas',
            'BH' => 'Bahrein',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BE' => 'Belgio',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BY' => 'Bielorussia',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia Erzegovina',
            'BW' => 'Botswana',
            'BR' => 'Brasile',
            'BN' => 'Brunei',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambogia',
            'CM' => 'Camerun',
            'CA' => 'Canada',
            'CV' => 'Capo Verde',
            'TD' => 'Ciad',
            'CL' => 'Cile',
            'CN' => 'Cina',
            'CY' => 'Cipro',
            'CO' => 'Colombia',
            'KM' => 'Comore',
            'CG' => 'Congo',
            'KP' => 'Corea del Nord',
            'KR' => 'Corea del Sud',
            'CR' => 'Costa Rica',
            'CI' => 'Costa d’Avorio',
            'HR' => 'Croazia',
            'CU' => 'Cuba',
            'DK' => 'Danimarca',
            'DM' => 'Dominica',
            'EC' => 'Ecuador',
            'EG' => 'Egitto',
            'SV' => 'El Salvador',
            'AE' => 'Emirati Arabi Uniti',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Etiopia',
            'RU' => 'Federazione Russa',
            'FJ' => 'Figi',
            'PH' => 'Filippine',
            'FI' => 'Finlandia',
            'FR' => 'Francia',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'GS' => 'Georgia del Sud e Isole Sandwich del Sud',
            'DE' => 'Germania',
            'GH' => 'Ghana',
            'JM' => 'Giamaica',
            'JP' => 'Giappone',
            'GI' => 'Gibilterra',
            'DJ' => 'Gibuti',
            'JO' => 'Giordania',
            'GR' => 'Grecia',
            'GD' => 'Grenada',
            'GL' => 'Groenlandia',
            'GP' => 'Guadalupa',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GF' => 'Guiana Francese',
            'GN' => 'Guinea',
            'GQ' => 'Guinea Equatoriale',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HN' => 'Honduras',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Irlanda',
            'IS' => 'Islanda',
            'BV' => 'Isola Bouvet',
            'NF' => 'Isola Norfolk',
            'CX' => 'Isola di Christmas',
            'IM' => 'Isola di Man',
            'AX' => 'Isole Aland',
            'KY' => 'Isole Cayman',
            'CC' => 'Isole Cocos',
            'CK' => 'Isole Cook',
            'FK' => 'Isole Falkland',
            'FO' => 'Isole Faroe',
            'HM' => 'Isole Heard ed Isole McDonald',
            'MP' => 'Isole Marianne Settentrionali',
            'MH' => 'Isole Marshall',
            'UM' => 'Isole Minori lontane dagli Stati Uniti',
            'SB' => 'Isole Solomon',
            'TC' => 'Isole Turks e Caicos',
            'VI' => 'Isole Vergini Americane',
            'VG' => 'Isole Vergini Britanniche',
            'IL' => 'Israele',
            'Italia' => 'IT',
            'JE' => 'Jersey',
            'KZ' => 'Kazakistan',
            'KE' => 'Kenya',
            'KG' => 'Kirghizistan',
            'KI' => 'Kiribati',
            'KW' => 'Kuwait',
            'LA' => 'Laos',
            'LS' => 'Lesotho',
            'LV' => 'Lettonia',
            'LB' => 'Libano',
            'LR' => 'Liberia',
            'LY' => 'Libia',
            'LI' => 'Liechtenstein',
            'LT' => 'Lituania',
            'LU' => 'Lussemburgo',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MV' => 'Maldive',
            'MY' => 'Malesia',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MA' => 'Marocco',
            'MQ' => 'Martinica',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Messico',
            'FM' => 'Micronesia',
            'MD' => 'Moldavia',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MZ' => 'Mozambico',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NO' => 'Norvegia',
            'NC' => 'Nuova Caledonia',
            'NZ' => 'Nuova Zelanda',
            'OM' => 'Oman',
            'NL' => 'Paesi Bassi',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestina',
            'PA' => 'Panama',
            'PG' => 'Papua Nuova Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Perù',
            'PN' => 'Pitcairn',
            'PF' => 'Polinesia Francese',
            'PL' => 'Polonia',
            'PT' => 'Portogallo',
            'PR' => 'Portorico',
            'QA' => 'Qatar',
            'HK' => 'Regione Amministrativa Speciale di Hong Kong della Repubblica Popolare Cinese',
            'MO' => 'Regione Amministrativa Speciale di Macao della Repubblica Popolare Cinese',
            'GB' => 'Regno Unito',
            'CZ' => 'Repubblica Ceca',
            'CF' => 'Repubblica Centrafricana',
            'CD' => 'Repubblica Democratica del Congo',
            'DO' => 'Repubblica Dominicana',
            'MK' => 'Repubblica di Macedonia',
            'RO' => 'Romania',
            'RW' => 'Ruanda',
            'RE' => 'Réunion',
            'EH' => 'Sahara Occidentale',
            'KN' => 'Saint Kitts e Nevis',
            'LC' => 'Saint Lucia',
            'PM' => 'Saint Pierre e Miquelon',
            'VC' => 'Saint Vincent e Grenadines',
            'WS' => 'Samoa',
            'AS' => 'Samoa Americane',
            'BL' => 'San Bartolomeo',
            'SM' => 'San Marino',
            'SH' => 'Sant’Elena',
            'ST' => 'Sao Tomé e Príncipe',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'CS' => 'Serbia e Montenegro',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SY' => 'Siria',
            'SK' => 'Slovacchia',
            'SI' => 'Slovenia',
            'SO' => 'Somalia',
            'Spagna' => 'ES',
            'LK' => 'Sri Lanka',
            'US' => 'Stati Uniti',
            'ZA' => 'Sudafrica',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard e Jan Mayen',
            'SE' => 'Svezia',
            'CH' => 'Svizzera',
            'SZ' => 'Swaziland',
            'TJ' => 'Tagikistan',
            'TH' => 'Tailandia',
            'TW' => 'Taiwan',
            'TZ' => 'Tanzania',
            'TF' => 'Territori australi francesi',
            'IO' => 'Territorio Britannico dell’Oceano Indiano',
            'TL' => 'Timor Est',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad e Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turchia',
            'TM' => 'Turkmenistan',
            'TV' => 'Tuvalu',
            'UA' => 'Ucraina',
            'UG' => 'Uganda',
            'HU' => 'Ungheria',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VA' => 'Vaticano',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis e Futuna',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
            'ZZ' => 'regione non valida o sconosciuta',

        );

        return $nazioni_it[Ucwords($nomeNazione)];
    }
    public function getSiglaProvinciaFromNome($nomeProvincia){
        $province = array(
            'Agrigento' => 'AG',
            'Alessandria' => 'AL',
            'Ancona' => 'AN',
            'Aosta' => 'AO',
            'Arezzo' => 'AR',
            'Ascoli Piceno' => 'AP',
            'Asti' => 'AT',
            'Avellino' => 'AV',
            'Bari' => 'BA',
            'Barletta-Andria-Trani' => 'BT',
            'Belluno' => 'BL',
            'Benevento' => 'BN',
            'Bergamo' => 'BG',
            'Biella' => 'BI',
            'Bologna' => 'BO',
            'Bolzano' => 'BZ',
            'Brescia' => 'BS',
            'Brindisi' => 'BR',
            'Cagliari' => 'CA',
            'Caltanissetta' => 'CL',
            'Campobasso' => 'CB',
            'Carbonia-Iglesias' => 'CI',
            'Caserta' => 'CE',
            'Catania' => 'CT',
            'Catanzaro' => 'CZ',
            'Chieti' => 'CH',
            'Como' => 'CO',
            'Cosenza' => 'CS',
            'Cremona' => 'CR',
            'Crotone' => 'KR',
            'Cuneo' => 'CN',
            'Enna' => 'EN',
            'Fermo' => 'FM',
            'Ferrara' => 'FE',
            'Firenze' => 'FI',
            'Foggia' => 'FG',
            'Forlì-Cesena' => 'FC',
            'Frosinone' => 'FR',
            'Genova' => 'GE',
            'Gorizia' => 'GO',
            'Grosseto' => 'GR',
            'Imperia' => 'IM',
            'Isernia' => 'IS',
            'La Spezia' => 'SP',
            'L\'Aquila' => 'AQ',
            'Latina' => 'LT',
            'Lecce' => 'LE',
            'Lecco' => 'LC',
            'Livorno' => 'LI',
            'Lodi' => 'LO',
            'Lucca' => 'LU',
            'Macerata' => 'MC',
            'Mantova' => 'MN',
            'Massa-Carrara' => 'MS',
            'Matera' => 'MT',
            'Messina' => 'ME',
            'Milano' => 'MI',
            'Modena' => 'MO',
            'Monza e della Brianza' => 'MB',
            'Napoli' => 'NA',
            'Novara' => 'NP',
            'Nuoro' => 'NU',
            'Olbia-Tempio' => 'OT',
            'Oristano' => 'OR',
            'Padova' => 'PD',
            'Palermo' => 'PA',
            'Parma' => 'PR',
            'Pavia' => 'PV',
            'Perugia' => 'PG',
            'Pesaro e Urbino' => 'PU',
            'Pescara' => 'PE',
            'Piacenza' => 'PC',
            'Pisa' => 'PI',
            'Pistoia' => 'PT',
            'Pordenone' => 'PN',
            'Potenza' => 'PZ',
            'Prato' => 'PO',
            'Ragusa' => 'RG',
            'Ravenna' => 'RA',
            'Reggio Calabria' => 'RC',
            'Reggio Emilia' => 'RE',
            'Rieti' => 'RI',
            'Rimini' => 'RN',
            'Roma' => 'RM',
            'Rovigo' => 'RO',
            'Salerno' => 'SA',
            'Medio Campidano' => 'VS',
            'Sassari' => 'SS',
            'Savona' => 'SV',
            'Siena' => 'SI',
            'Siracusa' => 'SR',
            'Sondrio' => 'SO',
            'Taranto' => 'TA',
            'Teramo' => 'TE',
            'Terni' => 'TR',
            'Torino' => 'TO',
            'Ogliastra' => 'OG',
            'Trapani' => 'TP',
            'Trento' => 'TN',
            'Treviso' => 'TV',
            'Trieste' => 'TS',
            'Udine' => 'UD',
            'Varese' => 'VA',
            'Venezia' => 'VE',
            'Verbano-Cusio-Ossola' => 'VB',
            'Vercelli' => 'VC',
            'Verona' => 'VR',
            'Vibo Valentia' => 'VV',
            'Vicenza' => 'VI',
            'Viterbo' => 'VT',
          );

          return $province[Ucwords($nomeProvincia)];
    }
    public function RateLimit(){
        $redis = new \Redis(); 
        //$redis->connect($this->redis_host, $this->redis_port); 

        try {
            $redis->connect($this->redis_host, $this->redis_port); 
            $adapter = new RedisAdapter(($redis)); 
            if ($this->redis_pass!='') $redis->auth($this->redis_pass);
            $rateLimit = new RateLimit("myratelimit", $this->RateLimitMaxRequest, $this->RateLimitRequestTime, $adapter); // 100 Requests / Hour

            
            $id = $this->RateLimitIPCheck;
            if (!$rateLimit->check($id)) {
                echo "Rate limit exceeded";
                exit();
            }
        } catch(\RedisException $ex) {
            $m = $ex->getMessage();
            error_log("ERROR: REDIS ($m)\n");
        }
        
    }

    public function createQRCode($coupon_codice){
        $options = new QROptions;
 
        $options->version             = 7;
        $options->outputType          = QROutputInterface::IMAGICK;
        $options->imagickFormat       = 'png';
        $options->quality             = 90;
        $options->scale               = 5;
        $options->outputBase64        = false;
        $options->bgColor             = '#ccccaa';
        $options->imageTransparent    = true;
        $options->transparencyColor   = '#ccccaa';
        $options->drawLightModules    = true;
        $options->drawCircularModules = true;
        $options->circleRadius        = 0.4;
        $options->keepAsSquare        = [
            QRMatrix::M_FINDER_DARK,
            QRMatrix::M_FINDER_DOT,
            QRMatrix::M_ALIGNMENT_DARK,
        ];
        $options->moduleValues        = [
            // finder
            QRMatrix::M_FINDER_DARK    => '#A71111', // dark (true)
            QRMatrix::M_FINDER_DOT     => '#A71111', // finder dot, dark (true)
            QRMatrix::M_FINDER         => '#FFBFBF', // light (false)
            // alignment
            QRMatrix::M_ALIGNMENT_DARK => '#A70364',
            QRMatrix::M_ALIGNMENT      => '#FFC9C9',
            // timing
            QRMatrix::M_TIMING_DARK    => '#98005D',
            QRMatrix::M_TIMING         => '#FFB8E9',
            // format
            QRMatrix::M_FORMAT_DARK    => '#003804',
            QRMatrix::M_FORMAT         => '#CCFB12',
            // version
            QRMatrix::M_VERSION_DARK   => '#650098',
            QRMatrix::M_VERSION        => '#E0B8FF',
            // data
            QRMatrix::M_DATA_DARK      => '#4A6000',
            QRMatrix::M_DATA           => '#ECF9BE',
            // darkmodule
            QRMatrix::M_DARKMODULE     => '#080063',
            // separator
            QRMatrix::M_SEPARATOR      => '#DDDDDD',
            // quietzone
            QRMatrix::M_QUIETZONE      => '#DDDDDD',
        ];
        
        
        $out = (new QRCode($options))->render($coupon_codice);
        return $out;
    }
}
?>