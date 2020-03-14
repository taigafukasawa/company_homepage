<?php

$post = $_POST;

if(!$post) {
  // forDebug
  $post = array(
    "name_sei"        => "藤崎",
    "name_mei"        => "顕彰",
    "email"           => "kensho.fujisaki@localia.co.jp",
    "companyname"     => "株式会社ロカリア",
    "dept"            => "技術開発部",
    "tel"             => "080-5254-8577",
    "contact_purpose" => "サービス利用に関するご相談",
    "comments"        => "フライヤー資料をPDFでください。"
  );

  exit();
}

// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

// バリデーションチェック
$input_entity = array(
  "name_sei"        => "氏名(性)",
  "name_mei"        => "氏名(名)",
  "email"           => "メールアドレス",
  "companyname"     => "会社名",
  "dept"            => "部署名",
  "tel"             => "電話番号",
  "contact_purpose" => "お問い合わせ目的",
  "comments"        => "お問い合わせ内容"
);

// 入力漏れチェック
$validation_error_list = array();
foreach($input_entity as $key => $value) {
  if(trim($post[$key]) == '') {
    array_push($validation_error_list, "<strong>" . $value . "</strong>を入力してください。");
  }
}

// アドレス不正チェック
if(trim($post['email'])!='' && !isEmail($post['email'])) {
  array_push($validation_error_list, "<strong>" . $input_entity['email'] . ":" . $post['email'] . "</strong>が正しくありません。再度入力してください。");
}

// エラーがあればその旨返却して終了
if(count($validation_error_list) != 0) {
  echo '<div class="error_message"><ul><li>' . implode("</li><li>", $validation_error_list) . '</li></ul></div>';
  exit();
}

$post['comments'] = stripslashes($post['comments']);

// メール作成
$address = "localia.external@gmail.com";
$e_subject = '【ロカリアHP】' . $post['name_sei'] . ' ' . $post['name_mei'] . '様からの問合せ';
$msg = '';
foreach($input_entity as $key => $value) {
  $msg = $msg . $value . PHP_EOL . $post[$key] . PHP_EOL . PHP_EOL;
}
$headers = "From: " . $post['email'] . PHP_EOL;
$headers .= "Reply-To: " . $post['email'] . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

// メール送信
if(mail($address, $e_subject, $msg, $headers)) {
	echo "<fieldset>";
	echo "<div id='success_page'>";
  echo "<h3 class='succes_message'>" . $post['name_sei'] . "様、お問い合わせいただきありがとうございます。</h3>";
	echo "<p>ご入力いただいたメールアドレス <strong>" . $post['email'] .  "</strong> まで、担当のものより2-3営業日以内にご連絡いたします。</p>";
	echo "<p>別のお問い合わせを行いたい際には、お手数ですが画面の再読み込みを行ってからお問い合わせください。</p>";
	echo "</div>";
	echo "</fieldset>";
} else {
	echo '申し訳ありません、サーバ障害が発生しました。再度お問い合わせをお願いいたします。';
}
