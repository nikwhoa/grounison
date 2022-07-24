<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>


<?php /* translators: %s: Customer first name */ ?>
<p><?php if($order->get_customer_note() == "ee") {echo '<div style="font-size: 28px;font-weight: 600;color: #0a0a0a;">Hea '.$order->get_billing_first_name().',</div>';} if($order->get_customer_note() == "lv") {echo '<div style="font-size: 28px;font-weight: 600;color: #0a0a0a;">Sveiki '.$order->get_billing_first_name().',</div>';} if($order->get_customer_note() == "ru") {echo '<div style="font-size: 28px;font-weight: 600;color: #0a0a0a;">Привет, '.$order->get_billing_first_name().'!</div>';} if($order->get_customer_note() == "fi") {echo '<div style="font-size: 28px;font-weight: 600;color: #0a0a0a;">Hea '.$order->get_billing_first_name().',</div>';} if($order->get_customer_note() == "lt") {echo '<div style="font-size: 28px;font-weight: 600;color: #0a0a0a;">Sveiki '.$order->get_billing_first_name().'!</div>';} ?><br>
<b style="font-size: 28px;color: #0a0a0a;font-family: Helvetica,Arial,sans-serif;font-weight: 400;padding: 0;line-height: 3.3;"><?php if($order->get_customer_note() == "lt") {echo 'Ačiū už užsakymą!';} if($order->get_customer_note() == "ee") {echo 'Täname tellimuse eest!';} if($order->get_customer_note() == "ru") {echo 'Спасибо за заказ!';} if($order->get_customer_note() == "fi") {echo 'Täname tellimuse eest!';} if($order->get_customer_note() == "lv") {echo 'Paldies par pasūtījumu!';} ?></b><br>
<?php 
if($order->get_customer_note() == "ee") {echo '
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Kohaletoimetamine Teie valitud pakiautomaati võtab tavaliselt 3-5 päeva.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Kui tellimuse täitmise osas tekib küsimusi palume võtta meiega ühendust:<br>
sales.barberpro@gmail.com </p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Tellimuse info on kuvatud allpool.</p>';}


if($order->get_customer_note() == "lv") {echo '<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
    margin-top: -20px;
">Ja grozā ir bijušas elektroniskās preces, tās jau ir nosūtītas uz norādīto pastkastīti</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
          ">Fiziskās preces tiks nokomplektētas, iepakotas un nosūtītas tuvākajā laikā.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Piegāde uz jūsu izvēlēto pakomātu parasti aizņem 1-3 darbdienas.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Ja jums ir kādi jautājumi par pasūtījuma izpildi, lūdzu, sazinieties ar mums:<br>
sales.barberpro@gmail.com </p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Informācija par pasūtījumu ir parādīta zemāk.</p>';}


if($order->get_customer_note() == "lt") {echo '<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
    margin-top: -20px;
">Elektroninės prekės, jei jų buvo krepšelyje, jau išsiųstos į nurodytą pašto dėžutę.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
          ">Fizinė prekė bus surinkta, supakuota ir netrukus išsiųsta.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Pristatymas į pasirinktą paštomatą paprastai trunka 1-3 darbo dienas.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Jei turite klausimų dėl užsakymo įvykdymo, susisiekite su mumis:<br>
sales.barberpro@gmail.com </p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Informacija apie užsakymą pateikiama žemiau.</p>';}



if($order->get_customer_note() == "ru") {echo '
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Доставка до выбранного вами почтомата обычно занимает 3-5 рабочих дней.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Если у Вас возникли вопросы по выполнению заказа, свяжитесь с нами:<br>
sales.barberpro@gmail.com </p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Информация о заказе приведена ниже.</p>';}

if($order->get_customer_note() == "fi") {echo '<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
    margin-top: -20px;
">Elektroonilised kaubad, kui olid korvis, on juba saadetud antud aadressile.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
          ">Füüsilised kaubad pannakse kokku, pakitakse ja saadetakse esimesel võimalusel.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Kohaletoimetamine Teie valitud pakiautomaati võtab tavaliselt 1-3 tööpäeva.</p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Kui tellimuse täitmise osas tekib küsimusi palume võtta meiega ühendust:<br>
sales.barberpro@gmail.com </p>
<p style="
    color: #0a0a0a;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 13px;
    font-weight: 400;
    line-height: 1.3;
    margin: 0;
    margin-bottom: 10px;
    padding: 0;
           ">Tellimuse info on kuvatud allpool.</p>';}
 ?>
</p>




<table style="margin-left:-16px;margin-top:30px;border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:397.33px">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Kliendi nimi (Eraisik)";} if($order->get_customer_note() == "lv") {echo "Klienta vārds (privātpersona)";} if($order->get_customer_note() == "lt") {echo "Kliento vardas (privatus asmuo)";} if($order->get_customer_note() == "fi") {echo "Kliendi nimi (Eraisik)";} if($order->get_customer_note() == "ru") {echo "Имя клиента";}?></strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo $order->get_billing_first_name().' '.$order->get_billing_last_name(); ?></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Telefon";} if($order->get_customer_note() == "lv") {echo "Tālrunis";} if($order->get_customer_note() == "lt") {echo "Telefonas";} if($order->get_customer_note() == "fi") {echo "Telefon";} if($order->get_customer_note() == "ru") {echo "Телефон";}?></strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><span class="js-phone-number"><?php echo $order->get_billing_phone();?></span></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong>E-mail</strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><a target="_blank" rel=" noopener noreferrer"><?php echo $order->get_billing_email();?></a></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Tarnija";} if($order->get_customer_note() == "lv") {echo "Piegādātājs";} if($order->get_customer_note() == "lt") {echo "Tiekėjas";} if($order->get_customer_note() == "fi") {echo "Tarnija";} if($order->get_customer_note() == "ru") {echo "Доставка";}?></strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo $order->get_shipping_method(); ?></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <!-- <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Tarneaadress";} if($order->get_customer_note() == "lv") {echo "Piegādes adrese";} if($order->get_customer_note() == "lt") {echo "Pristatymo adresas";} if($order->get_customer_note() == "fi") {echo "Tarneaadress";} if($order->get_customer_note() == "ru") {echo "Адрес доставки";}?></strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo $order->get_shipping_address_1().' - '.$order->get_shipping_city().', '.$order->get_shipping_address_2(); ?></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table> -->
                     </th>
                  </tr>
               </tbody>
            </table>
         </th>
         <!-- <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:190.67px">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                        <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:right"><strong>BARBERPRO OÜ</strong></p>
                        <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:right"><a target="_blank" rel=" noopener noreferrer">sales.barberpro@gmail.com</a></p>
                        <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:right"></p>
                        <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:right"><strong>Reg. nr</strong> 14718534</p>
                     </th>
                  </tr>
               </tbody>
            </table>
         </th> -->
      </tr>
   </tbody>
</table>












<table style="margin-top: 30px;margin-left: -16px;border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%;">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:397.33px">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Tellimuse kinnituse nr";} if($order->get_customer_note() == "lv") {echo "Pasūtījuma apstiprinājums Nr";} if($order->get_customer_note() == "lt") {echo "Užsakymo patvirtinimas Nr";} if($order->get_customer_note() == "fi") {echo "Tellimuse kinnituse nr";} if($order->get_customer_note() == "ru") {echo "Номер заказа";}?></strong></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo $order->get_id(); ?></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><!-- <strong><?php if($order->get_customer_note() == "ee") {echo "Kuupäev";} if($order->get_customer_note() == "lv") {echo "Datums";} if($order->get_customer_note() == "lt") {echo "Data";} if($order->get_customer_note() == "fi") {echo "Kuupäev";} if($order->get_customer_note() == "ru") {echo "Дата заказа";}?></strong> --></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                                <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo substr($order->get_date_paid(), 0, 10);?></p>
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                        <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">

                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                                 <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:0!important;padding-right:0!important;text-align:left;width:50%;word-break:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                                       <tbody>
                                          <tr style="padding:0;text-align:left;vertical-align:top">
                                             <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
  
                                             </th>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
         </th>
         <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:190.67px">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left"></th>
                  </tr>
               </tbody>
            </table>
         </th>
      </tr>
   </tbody>
</table>
















<table style="margin-left: -16px;margin-top: 30px;border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%;">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:16px;text-align:left;width:604px;word-break:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;">
                        <h4 style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:24px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left;word-wrap:normal"><?php if($order->get_customer_note() == "ee") {echo "Tooted";} if($order->get_customer_note() == "lv") {echo "Produkti";} if($order->get_customer_note() == "lt") {echo "Produktai";} if($order->get_customer_note() == "fi") {echo "Tooted";} if($order->get_customer_note() == "ru") {echo "Товары";}?></h4>
                     </th>
                     <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0!important;text-align:left;width:0"></th>
                  </tr>
               </tbody>
            </table>
         </th>
      </tr>
   </tbody>
</table>



















<table align="center" style="margin-left: -16px;border-collapse:collapse;border-spacing:0;border-top:1px solid #f3f3f3;padding:0;text-align:left;vertical-align:top;width:100%;">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <td style="margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <td height="16px" style="margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:16px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
            


<?php
foreach ( $order->get_items() as $item_id => $item ) {
   $product_id = $item->get_product_id();
   $variation_id = $item->get_variation_id();
   $product = $item->get_product();
   $name = $item->get_name();
   $quantity = $item->get_quantity();
   $subtotal = $item->get_subtotal();
   $total = $item->get_total();
   $tax = $item->get_subtotal_tax();
   $taxclass = $item->get_tax_class();
   $taxstat = $item->get_tax_status();
   $allmeta = $item->get_meta_data();
   $somemeta = $item->get_meta( '_whatever', true );
   $type = $item->get_type();
   $not_total = $subtotal / $quantity;
   echo '
               <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"> <strong>'.$name.'</strong> </p>

                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:8px;text-align:left;width:139px">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong>'.$not_total.'.00€</strong> x <strong>'.$quantity.'tk</strong></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:16px;padding-left:8px;padding-right:16px;text-align:left;width:139px">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:right"><strong>'.$subtotal.'.00€</strong></p>

                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
   ';
}
?>
 



         </td>
      </tr>
   </tbody>
</table>







<table align="center" style="margin-left: -16px;border-collapse:collapse;border-spacing:0;border-top:1px solid #f3f3f3;padding:0;text-align:left;vertical-align:top;width:100%;">
   <tbody>
      <tr style="padding:0;text-align:left;vertical-align:top">
         <td style="margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <td height="30px" style="margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:400;line-height:30px;margin:0;padding:0;text-align:left;vertical-align:top;word-wrap:break-word">&nbsp;</td>
                  </tr>
               </tbody>
            </table>
            <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php if($order->get_customer_note() == "ee") {echo "Vahesumma";} if($order->get_customer_note() == "lv") {echo "Starpsumma";} if($order->get_customer_note() == "lt") {echo "Tarpinė suma";} if($order->get_customer_note() == "fi") {echo "Vahesumma";} if($order->get_customer_note() == "ru") {echo "Подытог";}?></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php echo $order->get_subtotal();?>€</p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
            <!-- <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php if($order->get_customer_note() == "ee") {echo "Kupong";} if($order->get_customer_note() == "lv") {echo "Kupons";} if($order->get_customer_note() == "lt") {echo "Kuponas";} if($order->get_customer_note() == "fi") {echo "Kupong";} if($order->get_customer_note() == "ru") {echo "Купон";}?></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">-<?php echo $order->get_discount_total(); ?>€</p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table> -->
            <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php if($order->get_customer_note() == "ee") {echo "Transpordi tasu";} if($order->get_customer_note() == "lv") {echo "Transporta maksa";} if($order->get_customer_note() == "lt") {echo "Transporto mokestis";} if($order->get_customer_note() == "fi") {echo "Transpordi tasu";} if($order->get_customer_note() == "ru") {echo "Транспортные затраты";}?></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php echo $order->get_shipping_total();?>€</strong></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
            <!-- <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><?php if($order->get_customer_note() == "ee") {echo "Sisaldab käibemaksu (0%)";} if($order->get_customer_note() == "lv") {echo "Ietver PVN (0%)";} if($order->get_customer_note() == "lt") {echo "Su PVM (0%)";} if($order->get_customer_note() == "fi") {echo "Sisaldab käibemaksu (0%)";} if($order->get_customer_note() == "ru") {echo "Налог (0%)";}?></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left">0.00€</p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table> -->
            <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">

                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">









                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
            <table style="border-collapse:collapse;border-spacing:0;display:table;padding:0;text-align:left;vertical-align:top;width:100%">
               <tbody>
                  <tr style="padding:0;text-align:left;vertical-align:top">
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-right:8px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;/*color:#00bea2!important;*/font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php if($order->get_customer_note() == "ee") {echo "Kokku";} if($order->get_customer_note() == "lv") {echo "Kopā";} if($order->get_customer_note() == "lt") {echo "Kartu";} if($order->get_customer_note() == "fi") {echo "Kokku";} if($order->get_customer_note() == "ru") {echo "Итог";}?></strong></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                     <th style="margin:0 auto;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0 auto;padding:0;padding-bottom:0!important;padding-left:8px;padding-right:16px;text-align:left;width:294px;word-break:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding:0;text-align:left;vertical-align:top;width:100%">
                           <tbody>
                              <tr style="padding:0;text-align:left;vertical-align:top">
                                 <th style="margin:0;color:#0a0a0a;font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;padding:0;text-align:left">
                                    <p style="margin:0;margin-bottom:10px;/*color:#00bea2!important;*/font-family:Helvetica,Arial,sans-serif;font-size:13px;font-weight:400;line-height:1.3;margin:0;margin-bottom:10px;padding:0;text-align:left"><strong><?php echo $order->get_total();?>€</strong></p>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </th>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>






<?php
do_action( 'woocommerce_email_footer', $email ); ?>
