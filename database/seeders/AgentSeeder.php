<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Live\CCAgent;
use Illuminate\Database\Seeder;
use App\Models\PhrisUserDetails;
use Illuminate\Support\Facades\Hash;

class AgentSeeder extends Seeder
{
    public function array_except($array, $keys)
    {
        return array_diff_key($array, array_flip((array) $keys));
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Sample Dummy Users Array
        //php artisan db:seed --class=AgentSeeder

        $users = [
            [
                "man_no" => "73423",
                "name" => "AGNESS  TEMBO",
                "endpoint" => "1027",
                "email" => "agtembo@zesco.co.zm"
            ],
            [
                "man_no" => "74961",
                "name" => "AGNESS NAMFUKWE MUSONGOLE",
                "endpoint" => "8952",
                "email" => "amusongole@zesco.co.zm"
            ],
            [
                "man_no" => "75242",
                "name" => "AISSATA MUZALEMA JERE",
                "endpoint" => "8973",
                "email" => "zulua@zesco.co.zm"
            ],
            [
                "man_no" => "73914",
                "name" => "ALICE  MUTALE BANDA",
                "endpoint" => "8940",
                "email" => "alicebanda@zesco.cozm"
            ],
            [
                "man_no" => "77058",
                "name" => "ANDREW  BANDA",
                "endpoint" => "8703",
                "email" => "andybanda@zesco.co.zm"
            ],
            [
                "man_no" => "76273",
                "name" => "ANGEL  MAPOMA",
                "endpoint" => "8812",
                "email" => "amapoma@zesco.co.zm"
            ],
            [
                "man_no" => "71542",
                "name" => "ANGELA  CHILAO",
                "endpoint" => "8707",
                "email" => "achilao@zesco.co.zm"
            ],
            [
                "man_no" => "76221",
                "name" => "ANGELA TWAAMBO HAAKANTU",
                "endpoint" => "8966",
                "email" => "ahakaantu@zesco.co.zm"
            ],
            [
                "man_no" => "72484",
                "name" => "ANNIE  NYIRONGO",
                "endpoint" => "1029",
                "email" => "anyirongo@zesco.co.zm"
            ],
            [
                "man_no" => "74884",
                "name" => "ARTHUR  MWABA",
                "endpoint" => "8916",
                "email" => "amwaba@zesco.co.zm"
            ],
            [
                "man_no" => "76390",
                "name" => "BARETSI  CHILUMBA",
                "endpoint" => "1096",
                "email" => "bchilumba@zesco.co.zm"
            ],
            [
                "man_no" => "76687",
                "name" => "BENTU FRIDAH KAPUMPA",
                "endpoint" => "8706",
                "email" => "fbkapumba@zesco.co.zm"
            ],
            [
                "man_no" => "74880",
                "name" => "BETTY  MANDA",
                "endpoint" => "1013",
                "email" => "mandab@zesco.co.zm"
            ],
            [
                "man_no" => "71447",
                "name" => "BINA  ZIMBA",
                "endpoint" => "8944",
                "email" => "zimbab@zesco.co.zm"
            ],
            [
                "man_no" => "75319",
                "name" => "BRENDA CHIMWEMWE MULENGA",
                "endpoint" => "1005",
                "email" => "bmkaluba@zesco.co.zm"
            ],
            [
                "man_no" => "74087",
                "name" => "BRUNO IMBUNDA WAMWITA",
                "endpoint" => "8714",
                "email" => "bwamwita@zesco.co.zm "
            ],
            [
                "man_no" => "75405",
                "name" => "BWALYA NAVUULA NAMUGALA",
                "endpoint" => "1062",
                "email" => "bnamugala@zesco.co.zm"
            ],
            [
                "man_no" => "73211",
                "name" => "CALEB CHARLES KAMPALE KABINGA",
                "endpoint" => "8985",
                "email" => "ckabinga@zesco.co.zm"
            ],
            [
                "man_no" => "74420",
                "name" => "CAROLINE  CHISHIMBIKO",
                "endpoint" => "8964",
                "email" => "cchishimbiko@zesco.co.zm"
            ],
            [
                "man_no" => "75400",
                "name" => "CAROLINE  KALOKONI",
                "endpoint" => "1063",
                "email" => "kalokonic@zesco.co.zm"
            ],
            [
                "man_no" => "74352",
                "name" => "CAROLINE MUKUKA MWAMBA",
                "endpoint" => "1019",
                "email" => "camwamba@zesco.co.zm"
            ],
            [
                "man_no" => "72501",
                "name" => "CAROLYNE SHEZIPI BANDA",
                "endpoint" => "8932",
                "email" => "cshezibanda@zesco.co.zm"
            ],
            [
                "man_no" => "72473",
                "name" => "CATHERINE MUSONDA MWAPE",
                "endpoint" => "1028",
                "email" => "cmwape@zesco.co.zm"
            ],
            [
                "man_no" => "77288",
                "name" => "CATHERINE NEDZIWE MAWELE",
                "endpoint" => "1059",
                "email" => "cmawele@zesco.co.zm"
            ],
            [
                "man_no" => "75240",
                "name" => "CEPHAS  MOOMBA",
                "endpoint" => "8934",
                "email" => "cmoomba@zesco.co.zm"
            ],
            [
                "man_no" => "76434",
                "name" => "CHANDA  MWANGILWA",
                "endpoint" => "1004",
                "email" => "cmwangilwa@zesco.co.zm"
            ],
            [
                "man_no" => "75474",
                "name" => "CHEWE NATASHA SALOME CHISEMBELE",
                "endpoint" => "1002",
                "email" => "cnchisembele@zesco.co.zm"
            ],
            [
                "man_no" => "75015",
                "name" => "CHIBESA  CHUNGU",
                "endpoint" => "1091",
                "email" => "crchungu@zesco.co.zm"
            ],
            [
                "man_no" => "73795",
                "name" => "CHIBONI  MULENGA",
                "endpoint" => "8921",
                "email" => "cemulenga@zesco.co.zm"
            ],
            [
                "man_no" => "76404",
                "name" => "CHIBWE MASAITI KATEBE",
                "endpoint" => "1018",
                "email" => "cmkatebe@zesco.co.zm"
            ],
            [
                "man_no" => "73276",
                "name" => "CHILUFYA CHINOMBWE ",
                "endpoint" => "1066",
                "email" => "cchinombwe@zesco.co.zm"
            ],
            [
                "man_no" => "71426",
                "name" => "CHIMUKA JIMMY SYABBAMBA",
                "endpoint" => "8938",
                "email" => "csyabbamba@zesco.co.zm"
            ],
            [
                "man_no" => "76204",
                "name" => "CHIPO  MUKWAMBA",
                "endpoint" => "8963",
                "email" => "cmukwamba@zesco.co.zm "
            ],
            [
                "man_no" => "74356",
                "name" => "CHIPO SANDY SAKALA",
                "endpoint" => "1070",
                "email" => "cssakala@zesco.co.zm"
            ],
            [
                "man_no" => "74340",
                "name" => "CHRISTOPHER  MULENGA",
                "endpoint" => "8806",
                "email" => "christophermulenga@zesco.co.zm"
            ],
            [
                "man_no" => "74182",
                "name" => "CLIFF  CHIDUKA",
                "endpoint" => "1068",
                "email" => "cchiduka@zesco.co.zm"
            ],
            [
                "man_no" => "76721",
                "name" => "CREDO NAIMBWE NANJUWA",
                "endpoint" => "8705",
                "email" => "cnanjuwa@zesco.co.zm"
            ],
            [
                "man_no" => "75459",
                "name" => "DANNY WAMUNYIMA SABOI",
                "endpoint" => "1097",
                "email" => "dsaboi@zesco.co.zm"
            ],
            [
                "man_no" => "76250",
                "name" => "DIANA KALUMBA CHANSA",
                "endpoint" => "8825",
                "email" => "dkchansa@zesco.co.zm"
            ],
            [
                "man_no" => "74255",
                "name" => "DOROTHY  MULENGA",
                "endpoint" => "8955",
                "email" => "dmulenga@zesco.co.zm "
            ],
            [
                "man_no" => "75243",
                "name" => "DOROTHY CHIKWANDA CHISANGA",
                "endpoint" => "8914",
                "email" => "dchisanga@zesco.co.zm"
            ],
            [
                "man_no" => "75490",
                "name" => "EDWARD  MUTALE",
                "endpoint" => "8976",
                "email" => "edmutale@zesco.co.zm"
            ],
            [
                "man_no" => "72489",
                "name" => "EDWAYO  ZULU",
                "endpoint" => "1035",
                "email" => "edzulu@zesco.co.zm"
            ],
            [
                "man_no" => "77344",
                "name" => "ELIZABETH  CHILESHE",
                "endpoint" => "8709",
                "email" => "ecchisela@zesco.co.zm"
            ],
            [
                "man_no" => "73167",
                "name" => "ELLIAS  SOTA",
                "endpoint" => "8728",
                "email" => "esota@zesco.co.zm"
            ],
            [
                "man_no" => "74871",
                "name" => "ELVIS  SIWILA",
                "endpoint" => "8804",
                "email" => "esiwila@zesco.co.zm"
            ],
            [
                "man_no" => "71429",
                "name" => "ESNALA  BANDA",
                "endpoint" => "8953",
                "email" => "ebanda@zesco.co.zm"
            ],
            [
                "man_no" => "71573",
                "name" => "EUGINIA CHONGO SIAKALIMA",
                "endpoint" => "1024",
                "email" => "esiakalima@zesco.co.zm"
            ],
            [
                "man_no" => "71509",
                "name" => "FAITH   CHANDA CHISHIMBA",
                "endpoint" => "1095",
                "email" => "fchanda@zesco.co.zm"
            ],
            [
                "man_no" => "77287",
                "name" => "FAITH  PHIRI",
                "endpoint" => "8815",
                "email" => "faithphiri@zesco.co.zm"
            ],
            [
                "man_no" => "73738",
                "name" => "FAITH MWILA MWILA",
                "endpoint" => "8924",
                "email" => "faithmwila@zesco.co.zm"
            ],
            [
                "man_no" => "75023",
                "name" => "FALESI  MWAPE",
                "endpoint" => "8828",
                "email" => "phirif@zesco.co.zm"
            ],
            [
                "man_no" => "74334",
                "name" => "FIDELIS MUYANJE MULULU",
                "endpoint" => "8981",
                "email" => "fmululu@zesco.co.zm"
            ],
            [
                "man_no" => "74131",
                "name" => "FLORENCE MAKAYI NYIMBILI",
                "endpoint" => "8726",
                "email" => "fmnyimbili@zesco.co.zm"
            ],
            [
                "man_no" => "72778",
                "name" => "FRANCIS MALUMO SUSU",
                "endpoint" => "8724",
                "email" => "fsusu@zesco.co.zm"
            ],
            [
                "man_no" => "75254",
                "name" => "FRANCIS MWANSA CHAMA",
                "endpoint" => "8971",
                "email" => "fchanma@zesco.co.zm"
            ],
            [
                "man_no" => "77298",
                "name" => "FRANK  ZULU",
                "endpoint" => "8979",
                "email" => "frankzulu@zesco.co.zm"
            ],
            [
                "man_no" => "71487",
                "name" => "FRED  MUSWELE",
                "endpoint" => "8929",
                "email" => "fmuswele@zesco.co.zm"
            ],
            [
                "man_no" => "74324",
                "name" => "GEORGE CHINUKA NSUNGE",
                "endpoint" => "1049",
                "email" => "gnsunge@zesco.co.zm"
            ],
            [
                "man_no" => "74940",
                "name" => "GINA NYEMBEZI MWANZA",
                "endpoint" => "8941",
                "email" => "gmwanza@zesco.co.zm"
            ],
            [
                "man_no" => "71441",
                "name" => "GRACE NGANDWE SENDEME CHANDA",
                "endpoint" => "8909",
                "email" => "gsendeme@zesco.co.zm"
            ],
            [
                "man_no" => "70921",
                "name" => "HAZEL MUKOSA MULENGA",
                "endpoint" => "8723",
                "email" => "hphiri@zesco.co.zm"
            ],
            [
                "man_no" => "73994",
                "name" => "HELEN  SAMPA MUSONDA",
                "endpoint" => "8989",
                "email" => "hsampa@zesco.co.zm"
            ],
            [
                "man_no" => "75237",
                "name" => "HELGAH KATONGO KAMZIMBI",
                "endpoint" => "8995",
                "email" => "hkamzimbi@zesco.co.zm"
            ],
            [
                "man_no" => "74530",
                "name" => "HOPE  NAKAPILA",
                "endpoint" => "8977",
                "email" => "hkapila@zesco.co.zm"
            ],
            [
                "man_no" => "71685",
                "name" => "INONGE WENDY CHOLA",
                "endpoint" => "8901",
                "email" => "imubita@zesco.co.zm"
            ],
            [
                "man_no" => "77297",
                "name" => "INTERNAL  HANTETE",
                "endpoint" => "8996",
                "email" => "hinternal@zesco.co.zm"
            ],
            [
                "man_no" => "75633",
                "name" => "JAMES  KABAMBA",
                "endpoint" => "1072",
                "email" => "jkabamba@zesco.co.zm"
            ],
            [
                "man_no" => "73168",
                "name" => "JEFF  MWALE",
                "endpoint" => "8943",
                "email" => "mwalej@zesco.co.zm"
            ],
            [
                "man_no" => "75450",
                "name" => "JONATHAN CHIMEKO CHINGALA",
                "endpoint" => "1092",
                "email" => "jchingala@zesco.co.zm"
            ],
            [
                "man_no" => "77289",
                "name" => "JOSAN MULENGA PHIRI",
                "endpoint" => "8961",
                "email" => "josanphiri@zesco.co.zm"
            ],
            [
                "man_no" => "75434",
                "name" => "JOSEPH  LWENGA",
                "endpoint" => "1076",
                "email" => "jtlwenga@zesco.co.zm"
            ],
            [
                "man_no" => "72927",
                "name" => "JOSEPH  MITI",
                "endpoint" => "8947",
                "email" => "jomiti@zesco.co.zm"
            ],
            [
                "man_no" => "72279",
                "name" => "JOSEPH HAAMAKALU JALISO",
                "endpoint" => "1011",
                "email" => "jjaliso@zesco.co.zm"
            ],
            [
                "man_no" => "75238",
                "name" => "JOSEPHINE MUBANGA MWENYA",
                "endpoint" => "8992",
                "email" => "mmwenya@zesco.co.zm"
            ],
            [
                "man_no" => "77340",
                "name" => "JOSINA  BANDA",
                "endpoint" => "8717",
                "email" => "josinabanda@zesco.co.zm"
            ],
            [
                "man_no" => "74882",
                "name" => "JUDITH  MUDENDA",
                "endpoint" => "8722",
                "email" => "jnyirongo@zesco.co.zm"
            ],
            [
                "man_no" => "75263",
                "name" => "JUSTINE  KAMANGA",
                "endpoint" => "8993",
                "email" => "jkamanga@zesco.co.zm"
            ],
            [
                "man_no" => "75631",
                "name" => "KAPAMBWE  MUSHIKWA",
                "endpoint" => "1083",
                "email" => "kmushikwa@zesco.co.zm"
            ],
            [
                "man_no" => "71398",
                "name" => "KAREN  SAKALA",
                "endpoint" => "1058",
                "email" => "sakalak@zesco.co.zm"
            ],
            [
                "man_no" => "72823",
                "name" => "KELVIS  AKAPELWA",
                "endpoint" => "1033",
                "email" => "kakapelwa@zesco.co.zm"
            ],
            [
                "man_no" => "77057",
                "name" => "KETURAH  MILLAPO",
                "endpoint" => "8942",
                "email" => "kmillapo@zesco.co.zm "
            ],
            [
                "man_no" => "75211",
                "name" => "KOMBE MARY KANGOWA",
                "endpoint" => "8807",
                "email" => "kkangow@zesco.co.zm"
            ],
            [
                "man_no" => "74227",
                "name" => "LAZARUS MULENGA BWALYA",
                "endpoint" => "8928",
                "email" => "lmbwalya@zesco.co.zm"
            ],
            [
                "man_no" => "76251",
                "name" => "LILLIAN  KAFUTUBELE",
                "endpoint" => "8841",
                "email" => "lkafutubele@zesco.co.zm"
            ],
            [
                "man_no" => "75257",
                "name" => "LILY MUNSELE PHIRI",
                "endpoint" => "8907",
                "email" => "liphiri@zesco.co.zm "
            ],
            [
                "man_no" => "72037",
                "name" => "LINDA  MULUBE",
                "endpoint" => "1000",
                "email" => "lmulube@zesco.co.zm"
            ],
            [
                "man_no" => "77073",
                "name" => "LISA  MUYABA",
                "endpoint" => "1010",
                "email" => "lmuyaba@zesco.co.zm"
            ],
            [
                "man_no" => "75457",
                "name" => "LOUISE MISHENGO MUMBA",
                "endpoint" => "1094",
                "email" => "louisemumba@zesco.co.zm"
            ],
            [
                "man_no" => "76049",
                "name" => "LUMWAYA  NJELEKA",
                "endpoint" => "8824",
                "email" => "lnjeleka@zesco.co.zm"
            ],
            [
                "man_no" => "71425",
                "name" => "LUSANDE  YOYO",
                "endpoint" => "1001",
                "email" => "lyoyo@zesco.co.zm"
            ],
            [
                "man_no" => "76783",
                "name" => "LUYANDO  KAPUNGWE",
                "endpoint" => "8713",
                "email" => "lkapungwe@zesco.co.zm"
            ],
            [
                "man_no" => "71438",
                "name" => "LWIINDI  MUGANDE",
                "endpoint" => "8949",
                "email" => "lmugande@zesco.co.zm"
            ],
            [
                "man_no" => "73207",
                "name" => "MALELE SIBONGILE HAMOONGA",
                "endpoint" => "8990",
                "email" => "shamoonga@zesco.co.zm"
            ],
            [
                "man_no" => "71434",
                "name" => "MAREN MONICA NYIRENDA",
                "endpoint" => "8958",
                "email" => "mmlnyirenda@zesco.co.zm"
            ],
            [
                "man_no" => "71406",
                "name" => "MARIA ZUZIKA TEMBO",
                "endpoint" => "8970",
                "email" => "mztembo@zesco.co.zm"
            ],
            [
                "man_no" => "73208",
                "name" => "MARTHA  IKOWA",
                "endpoint" => "8983",
                "email" => "mikowa@zesco.co.zm"
            ],
            [
                "man_no" => "75429",
                "name" => "MARTHA  NYIRENDA",
                "endpoint" => "1075",
                "email" => "mjnyirenda@zesco.co.zm"
            ],
            [
                "man_no" => "75414",
                "name" => "MARY  MULENGA",
                "endpoint" => "8917",
                "email" => "marymulenga@zesco.co.zm"
            ],
            [
                "man_no" => "76209",
                "name" => "MARY MULELA KAUNDA",
                "endpoint" => "1014",
                "email" => "mmkaunda@zesco.co.zm"
            ],
            [
                "man_no" => "72687",
                "name" => "MARY MUSHIBA MUNALULA",
                "endpoint" => "8911",
                "email" => "munalulam@zesco.co.zm"
            ],
            [
                "man_no" => "72027",
                "name" => "MASANGA CHEELO HATOWA",
                "endpoint" => "1021",
                "email" => "mhatowa@zesco.co.zm"
            ],
            [
                "man_no" => "71424",
                "name" => "MATIYA  MBOROMA",
                "endpoint" => "8922",
                "email" => "mmatiya@zesco.co.zm"
            ],
            [
                "man_no" => "73191",
                "name" => "MAUREEN  NGOMA",
                "endpoint" => "8999",
                "email" => "ngomam@zesco.co.zm"
            ],
            [
                "man_no" => "72261",
                "name" => "MEMORY  MWAPE - MUSUMALI",
                "endpoint" => "1071",
                "email" => "mnmwape@zesco.co.zm"
            ],
            [
                "man_no" => "75835",
                "name" => "MERCY  NAMUKOKO",
                "endpoint" => "8997",
                "email" => "mnamukoko@zesco.co.zm"
            ],
            [
                "man_no" => "73982",
                "name" => "MERCY CHIBUYE DAKA",
                "endpoint" => "8930",
                "email" => "mercydaka@zesco.co.zm"
            ],
            [
                "man_no" => "75311",
                "name" => "MERVIS LWEENDO SIMANEGO",
                "endpoint" => "8833",
                "email" => "mlmmweene@zesco.co.zm"
            ],
            [
                "man_no" => "75393",
                "name" => "MILES  JERE",
                "endpoint" => "8818",
                "email" => "milesjere@zesco.co.zm"
            ],
            [
                "man_no" => "72719",
                "name" => "MILUPI  MWALA",
                "endpoint" => "1017",
                "email" => "mmwala@zesco.co.zm"
            ],
            [
                "man_no" => "75399",
                "name" => "MONICA CHIMPONDA SAFELI",
                "endpoint" => "1064",
                "email" => "msafeli@zesco.co.zm"
            ],
            [
                "man_no" => "72511",
                "name" => "MPEZA  CHIZAWU",
                "endpoint" => "1051",
                "email" => "mchizawu@zesco.co.zm"
            ],
            [
                "man_no" => "75436",
                "name" => "MSAIWALE  BANDA",
                "endpoint" => "1073",
                "email" => "msaiwalebanda@zesco.co.zm"
            ],
            [
                "man_no" => "71546",
                "name" => "MUKUKA CHRISTINE MULENGA",
                "endpoint" => "1032",
                "email" => "mukuka@zesco.co.zm"
            ],
            [
                "man_no" => "75500",
                "name" => "MULENGA  BWALYA",
                "endpoint" => "1009",
                "email" => "bwalyamulenga@zesco.co.zm"
            ],
            [
                "man_no" => "72639",
                "name" => "MULENGA  MUMBA",
                "endpoint" => "8827",
                "email" => "mulengamumba@zesco.co.zm"
            ],
            [
                "man_no" => "76407",
                "name" => "MUTALE  CHENGO",
                "endpoint" => "8727",
                "email" => "mchengo@zesco.co.zm"
            ],
            [
                "man_no" => "71924",
                "name" => "MUTALE MWESHI MWAANGA",
                "endpoint" => "8821",
                "email" => "mmweshi@zesco.co.zm"
            ],
            [
                "man_no" => "74256",
                "name" => "MUTINTA  BUBALA",
                "endpoint" => "8994",
                "email" => "mbubala@zesco.co.zm"
            ],
            [
                "man_no" => "75138",
                "name" => "MUTINTA  KEMBULE",
                "endpoint" => "8704",
                "email" => "mkembule@zesco.co.zm"
            ],
            [
                "man_no" => "72721",
                "name" => "MUTINTA CHEELO KALUBA",
                "endpoint" => "8803",
                "email" => "mckaluba@zesco.co.zm"
            ],
            [
                "man_no" => "74699",
                "name" => "MUTUNA ALLAN CHISUNKA",
                "endpoint" => "8939",
                "email" => "mchisunka@zesco.co.zm"
            ],
            [
                "man_no" => "71403",
                "name" => "MWANGALA  MBANGWETA",
                "endpoint" => "8910",
                "email" => "mmbangweta@zesco.co.zm"
            ],
            [
                "man_no" => "73916",
                "name" => "MWANSA  MUKALULA",
                "endpoint" => "8988",
                "email" => "mmukakula@zesco.co.zm"
            ],
            [
                "man_no" => "74626",
                "name" => "MWAPE PRINCESS MWAPE-PHIRI",
                "endpoint" => "8721",
                "email" => "mwapephiri@zesco.co.zm"
            ],
            [
                "man_no" => "72924",
                "name" => "MWEWA ELIVA JUMA",
                "endpoint" => "8948",
                "email" => "jumamwewa@zesco.co.zm"
            ],
            [
                "man_no" => "75239",
                "name" => "MWIZA  MAKUNI",
                "endpoint" => "8715",
                "email" => "nyirendam@zesco.co.zm"
            ],
            [
                "man_no" => "73929",
                "name" => "NATASHA  MUNGWA",
                "endpoint" => "8700",
                "email" => "nmungwa@zesco.co.zm"
            ],
            [
                "man_no" => "75826",
                "name" => "NELLY  CHITALA",
                "endpoint" => "8936",
                "email" => "nchitala@zesco.co.zm"
            ],
            [
                "man_no" => "71430",
                "name" => "NGABO DIANA MUSONGOLE",
                "endpoint" => "8823",
                "email" => "nmusongole@zesco.co.zm"
            ],
            [
                "man_no" => "71427",
                "name" => "NGOZA GRACE ZULU",
                "endpoint" => "8912",
                "email" => "gnzulu@zesco.co.zm"
            ],
            [
                "man_no" => "75635",
                "name" => "NKANDU MONICA MWELWA",
                "endpoint" => "8951",
                "email" => "mnmwelwa@zesco.co.zm"
            ],
            [
                "man_no" => "76048",
                "name" => "NORAH  MWALE",
                "endpoint" => "8956",
                "email" => "nmwale@zesco.co.zm"
            ],
            [
                "man_no" => "76767",
                "name" => "NTANDOSE  ZULU",
                "endpoint" => "8710",
                "email" => "ntandosezulu@zesco.co.zm"
            ],
            [
                "man_no" => "75093",
                "name" => "NYANGU  SHAKEMBA",
                "endpoint" => "8837",
                "email" => "nshakemba@zesco.co.zm"
            ],
            [
                "man_no" => "74177",
                "name" => "PATIENCE MUTALE MOYO",
                "endpoint" => "8702",
                "email" => "pmoyo@zesco.co.zm"
            ],
            [
                "man_no" => "71405",
                "name" => "PATRICIA NKHOMA MUYANZA",
                "endpoint" => "8915",
                "email" => "pmuyanza@zesco.co.zm"
            ],
            [
                "man_no" => "74918",
                "name" => "PAUL CHIMFWEMBE JEMUSALA",
                "endpoint" => "8701",
                "email" => "pjemusala@zesco.co.zm"
            ],
            [
                "man_no" => "75823",
                "name" => "PRINCE MUTONDO KAZHILA",
                "endpoint" => "8986",
                "email" => "pkazhila@zesco.co.zm"
            ],
            [
                "man_no" => "72504",
                "name" => "PRISCILLA BWALYA KALWA",
                "endpoint" => "8998",
                "email" => "pkalwa@zesco.co.zm"
            ],
            [
                "man_no" => "72133",
                "name" => "RICHARD  CHEELO",
                "endpoint" => "8725",
                "email" => "rcheelo@zesco.co.zm"
            ],
            [
                "man_no" => "73595",
                "name" => "RITA NKOMBO CHONA",
                "endpoint" => "8974",
                "email" => "rchona@zesco.co.zm"
            ],
            [
                "man_no" => "73633",
                "name" => "ROYDAH  KAMPENGELE",
                "endpoint" => "8716",
                "email" => "rkampemgele@zesco.co.zm"
            ],
            [
                "man_no" => "72553",
                "name" => "RUTH  NAMBAYA",
                "endpoint" => "1031",
                "email" => "rnambaya@zesco.co.zm"
            ],
            [
                "man_no" => "75469",
                "name" => "SAKILE  NSWANA",
                "endpoint" => "1050",
                "email" => "snswana@zesco.co.zm"
            ],
            [
                "man_no" => "76259",
                "name" => "SANDRA  TUPA",
                "endpoint" => "8836",
                "email" => "stupa@zesco.co.zm"
            ],
            [
                "man_no" => "72494",
                "name" => "SEKANJI  KALUBA",
                "endpoint" => "1030",
                "email" => "sekkaluba@zesco.co.zm"
            ],
            [
                "man_no" => "75403",
                "name" => "SENDA KAINA KAZHILA",
                "endpoint" => "1061",
                "email" => "skazhila@zesco.co.zm"
            ],
            [
                "man_no" => "72528",
                "name" => "SHANZIWE  NAKAZWE",
                "endpoint" => "1060",
                "email" => "snakazwe@zesco.co.zm"
            ],
            [
                "man_no" => "72631",
                "name" => "SIMON  CHAPELA",
                "endpoint" => "8980",
                "email" => "schapela@zesco.co.zm"
            ],
            [
                "man_no" => "71504",
                "name" => "SIMON  CHAVULA",
                "endpoint" => "8920",
                "email" => "schavula@zesco.co.zm"
            ],
            [
                "man_no" => "74596",
                "name" => "SYLVIA MWAANGA MUDENDA",
                "endpoint" => "1034",
                "email" => "mmudendachikatula@zesco.co.zm"
            ],
            [
                "man_no" => "74097",
                "name" => "TAMARA  MUNALULA",
                "endpoint" => "8913",
                "email" => "tmunalula@zesco.co.zm"
            ],
            [
                "man_no" => "75851",
                "name" => "TAMARA  MWANSA",
                "endpoint" => "8984",
                "email" => "tamamwansa@zesco.co.zm"
            ],
            [
                "man_no" => "76249",
                "name" => "TEDDY  VELEMU",
                "endpoint" => "8834",
                "email" => "tvelemu@zesco.co.zm"
            ],
            [
                "man_no" => "74921",
                "name" => "TEMWANI  NDOVI",
                "endpoint" => "1003",
                "email" => "tndovi@zesco.co.zm"
            ],
            [
                "man_no" => "70806",
                "name" => "TENDAI  MALUZA",
                "endpoint" => "8830",
                "email" => "tmaluza@zesco.co.zm"
            ],
            [
                "man_no" => "76412",
                "name" => "TINA  PHIRI",
                "endpoint" => "1023",
                "email" => "tinaphiri@zesco.co.zm"
            ],
            [
                "man_no" => "76435",
                "name" => "TOBIAS  DAKA",
                "endpoint" => "8945",
                "email" => "tobiasdaka@zesco.co.zm"
            ],
            [
                "man_no" => "76275",
                "name" => "TOTIWE  MUCHEMWA",
                "endpoint" => "8814",
                "email" => "tmuchemwa@zesco.co.zm"
            ],
            [
                "man_no" => "71404",
                "name" => "TRAGEDY MUSAKANYA MUMBI",
                "endpoint" => "8918",
                "email" => "mtmumbi@zesco.co.zm"
            ],
            [
                "man_no" => "71436",
                "name" => "TRINITY  CHILANDO MACHUNGANI",
                "endpoint" => "8719",
                "email" => "tchilando@zesco.co.zm"
            ],
            [
                "man_no" => "71387",
                "name" => "TRYWELL KALIZEZE SIAMABUYU",
                "endpoint" => "8923",
                "email" => "tsiamabuyu@zesco.co.zm"
            ],
            [
                "man_no" => "75318",
                "name" => "WALUMWEYA  MUBITANA",
                "endpoint" => "8954",
                "email" => "wmubitana@zesco.co.zm"
            ],
            [
                "man_no" => "75486",
                "name" => "WHITON  BANDA",
                "endpoint" => "8968",
                "email" => "whbanda@zesco.co.zm"
            ],
            [
                "man_no" => "71536",
                "name" => "YANDE  MULENGA",
                "endpoint" => "8903",
                "email" => "ymulenga@zesco.co.zm"
            ],
            [
                "man_no" => "75827",
                "name" => "YAZMINE KASONDE MUSUKWA",
                "endpoint" => "8931",
                "email" => "ymusukwa@zesco.co.zm"
            ],
            [
                "man_no" => "75411",
                "name" => "YOREEN SHUPIWE TEMBO",
                "endpoint" => "1067",
                "email" => "yoreentembo@zesco.co.zm"
            ],
            [
                "man_no" => "75282",
                "name" => "YVONNE YALUSA PHIRI",
                "endpoint" => "8810",
                "email" => "yyulasa@zesco.co.zm"
            ],
            [
                "man_no" => "71416",
                "name" => "ZAMIWE  PHIRI",
                "endpoint" => "8962",
                "email" => "zphiri@zesco.co.zm"
            ],
            [
                "man_no" => "73714",
                "name" => "ZEMBA NGOSA NGOSA",
                "endpoint" => "1006",
                "email" => "zngosa@zesco.co.zm"
            ]
        ];

        // Looping and Inserting Array's Users into User Table
        foreach ($users as $user) {

            $phris_user_details = PhrisUserDetails::select(
                'con_per_no',
                'nrc',
                'name',

                //'firstname',
                //'middlename',
                //'lastname',

                'dob',
                'sex',

                'mobile_no',
                'staff_email',
                //'password',


                'bu_code',
                'cc_code',
                'bu_name',
                'cc_name',
                'directorate',
                //'division',
                'location',
                'functional_section',
                'station',
                //'position',
                'job_code',
                'job_title',
                'grade',

                //'status',

                //'is_banned',
                //'banned_until',
                //'user_group_id'
            )
                ->where('con_per_no', $user['man_no'])
                ->where('con_st_code', 'ACT')
                ->first();

            //dd($phris_user_details);

            if (empty($phris_user_details)) {
                //return redirect()->back()->withInput()->withErrors(['man_no' => "Sorry! man number does not exists in PHCMS or is Inactive"]);
            } else {
                // $phris = PhrisUserDetails::where('con_per_no', $user['man_no'])
                //     ->first();

                $data = $phris_user_details->toArray();
                // dd($data);
                $data['man_no'] = $phris_user_details->con_per_no;
                $data['email'] = str_replace("payroll-reports@zesco.co.zm", null, trim(strtolower($phris_user_details->staff_email))) ?? strtolower($user['email']);
                $data['password'] = Hash::make("welcome123");

                $output = $this->array_except($data, [
                    'con_per_no',
                    'staff_email'
                ]);

                //dd($output);
                $createdUser = User::updateOrCreate(
                    [
                        'man_no' => $phris_user_details->con_per_no,
                    ],
                    $output
                );
                $createdUser->assignRole('agent');
                $createdUser->save();
            }
        }
    }
}
