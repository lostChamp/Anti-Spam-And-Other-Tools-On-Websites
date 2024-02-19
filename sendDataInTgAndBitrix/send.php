<?php
function arrPrint($data) {
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function txtForTg($title, $typeForm) {
    $questions = [
        "question_1" => "Сколько зубов нужно восставновить: ",
        "question_2" => "Зубов нет или сначала их нужно удалять: ",
        "question_3" => "Какие зубы восставносить: ",
        "question_4" => "Как вам будет удобно оплачивать лечение: ",
    ];

    $txt = $title . "%0A";
    $txt .= $typeForm . "%0A";
    $requiredFields = ["utm" => "utm_source: ", "utm_medium" => "utm_medium: ", "id" => "Номер телефона: "];
    foreach($requiredFields as $key => $value) {
        $txt .=  $value . $_POST[$key] . "%0A";
    }

    if($typeForm === "Пройден тест (квиз)") {
        $txt .= "%0A";
        foreach($questions as $key => $value) {
            $txt .= $value . $_POST[$key] . "%0A";
        }
    }

    if($typeForm === "Форма с вопросом и именем") {
        $txt .= "Имя: " . $_POST["name"] . "%0A" . "Вопрос: " . $_POST["question"] . "?";
    }

    return $txt;
}

if (isset($_POST['utm']) && $_POST['utm'] === 'test') {
    //test chat in tg
} else {
    //work chat in tg
}

$title = ""; //req title
$name = "";


//we determine which form the data came from
if(isset($_POST["subject"])) {
    $txt = txtForTg($title, $_POST["subject"]);
}else if(isset($_POST["tags"])){
    $txt = txtForTg($title, $_POST["tags"]);
}else {
    $txt = txtForTg($title, $_POST["with_name"]);
}

arrPrint($txt);

fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r"); // sending a request to the API Telegram

//options for sending req in Bitrix24

$bitrixName = '';
$bitrixId = '';
$url = 'https://' . $bitrixName . '.ru/rest/1/' . $bitrixId . '/crm.lead.add.json';

$dataArrId = "UF_CRM_1663916627";
$cityFieldId = "UF_CRM_1635751283979";

$txt = "";

$utm_source = "utm: " . $_POST["utm"] ?? "";
$utm_medium = "utm_medium: " . $_POST["utm_medium"] ?? "";
$utm_campaign = "utm_campaign: " . $_POST["utm_campaign"] ?? "";
$utm_content = "utm_content: " . $_POST["utm_content"] ?? "";
$utm_term = "utm_term: " . $_POST["utm_term"] ?? "";
$phone = "Номер телефона: " . $_POST["id"];

$dataArr = array(
    "phone" => $phone,
    "utm" => $utm_source,
    "utm_medium" => $utm_medium,
    "utm_campaign" => $utm_campaign,
    "utm_content" => $utm_content,
    "utm_term" => $utm_term,
);


$paramLid = http_build_query(array(
    'fields' => array(
        'TITLE' => $title, // НАЗВАНИЕ
        'NAME' => $name, // ИМЯ
        'PHONE' => Array(
            "n0" => Array(
                "VALUE" => str_replace(" ","",$_POST['id']),
                "VALUE_TYPE" => "WORK",
            )), // РАБОЧИЙ ТЕЛЕФОН в массиве
        'OPENED' => 'Y', // Доступно для всех
        'SOURCE_ID' => "WEB", //Источник
        'COMMENTS' => $txt, // Комментарий
        'UTM_SOURCE' => $_POST["utm"] ?? "",
        $cityFieldId => 53,
        'ASSIGNED_BY_ID' => 1, // Ид ответственного
        'UF_CRM_1698302617' => 'ultra.stoma-ekb.ru',
        $dataArrId => $dataArr, // Пользовательское поле

    ),
    'params' => array("REGISTER_SONET_EVENT" => "Y")
));

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_POSTFIELDS => $paramLid,
));
$result2 = curl_exec($ch);
curl_close($ch);


header(""); //Redirect
die();