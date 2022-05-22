<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>New User Registration</title>
</head>

<body style="width: 100%!important;margin: 0;padding: 0;background-color: #F8F8F8;">
    <table border="0" cellpadding="0" cellspacing="0" style="padding: 10px 0;width: 600px;margin: 0 auto;">
        <tr>
            <td>
                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;background-color: #FFF; padding: 20px">
                    <tr>
                        <td style="padding: 30px 10px 10px 10px;text-align: center;color: #32C1CE;font-size: 20px;letter-spacing: 1px;font-family: Open Sans,Helvetica,Arial,sans-serif;">Hello, {name}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: center;color: #555; font-size: 13px;line-height: 24px;letter-spacing: .5px;font-family: Open Sans,Helvetica,Arial,sans-serif;">
                           Welcome to <span style="color: #32C1CE">{site_name}</span>. Thanks for creating account with us. We're glad you're here. You're one step colser. Please follow below instruction ...
                       </td>
                   </tr>
                   <tr>
                    <td style="padding: 10px; text-align: center;color: #555; font-size: 13px;letter-spacing: .5px; line-height: 24px;font-family: Open Sans,Helvetica,Arial,sans-serif;">Please confirm your email address by clicking on the button below
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px;text-align: center;font-family: Open Sans,Helvetica,Arial,sans-serif;">
                        <a href="{site_link}register/verify&id={email}&code={code}" style="padding: 15px 20px; font-size: 14px;color: #FFF;letter-spacing: 1px; background-color:#32C1CE;text-decoration: none;border-radius: 4px;font-family: Open Sans,Helvetica,Arial,sans-serif;" target="_blank">Confirm Email Address</a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; text-align: center;color: #555; font-size: 13px;letter-spacing: .5px;font-family: Open Sans,Helvetica,Arial,sans-serif;">If you didn't create account, then contact our support team at <a href="{site_link}contact" target="_blank">Click Here</a>. </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" style="width: 600px; margin: 0 auto;">
                <tr>
                    <td style="text-align: center;font-size:12px;padding: 10px;color: #333;font-family: Open Sans,Helvetica,Arial,sans-serif;">This email was sent to you because you created account with us</td>
                </tr>
                <tr>
                    <td style="text-align: center;font-size:12px;padding: 10px;color: #333;font-family: Open Sans,Helvetica,Arial,sans-serif;">
                        *** This is an automatically generated email – please do not reply to it. If you have any queries, please visit our website.' ***
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>

</html>