 <?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if form fields exist before accessing them
    $name = isset($_POST["name"]) ? $_POST["name"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $phone = isset($_POST["phone"]) ? $_POST["phone"] : '';
    $service = isset($_POST["service"]) ? $_POST["service"] : '';
    $message = isset($_POST["message"]) ? $_POST["message"] : '';

    // Validate required fields
    if (empty($name) || empty($email) || empty($service) || empty($message)) {
        echo "
        <script>
         alert('Error: Please fill in all required fields.');
         document.location.href = 'contact.html';
        </script>
        ";
        exit;
    }

    try {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                              //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;             //Enable SMTP authentication
        $mail->Username   = 'neomoremongx@gmail.com';   //SMTP write your email
        $mail->Password   = 'pxcosqmpbjlodmyw';      //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
        $mail->Port       = 465;                                    

        //Recipients
        $mail->setFrom($email, $name); // Sender Email and name
        $mail->addAddress('neomoremongx@gmail.com');     //Add a recipient email  
        $mail->addReplyTo($email, $name); // reply to sender email

        //Content
        $mail->isHTML(true);               //Set email format to HTML
        $mail->Subject = "New Consultation Request: " . $service;   // email subject headings

        $formattedMessage = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f7fa;">
            <div style="max-width: 700px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                <!-- Header -->
                <div style="background: linear-gradient(135deg, #223849, #1b3942); color: #ffffff; padding: 40px 30px; text-align: center;">
                    <h1 style="font-family: Georgia, serif; font-size: 2.5rem; margin: 0 0 15px 0; color: #cda670;">New Consultation Request</h1>
                    <p style="font-size: 1.1rem; margin: 0; color: #e0d7cb; opacity: 0.9;">M. Makgetha Attorneys Inc. | Expert Legal Assistance</p>
                </div>
                
                <!-- Content -->
                <div style="padding: 40px 30px; background: #ffffff;">
                    <!-- Details Card -->
                    <div style="background: #f5f7fa; padding: 30px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #223849; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <div style="display: flex; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #e8ecf2;">
                            <div style="font-weight: 600; color: #cda670; width: 140px; flex-shrink: 0; font-family: Georgia, serif;">Client Name:</div>
                            <div style="color: #333333; flex: 1;">' . htmlspecialchars($name) . '</div>
                        </div>
                        
                        <div style="display: flex; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #e8ecf2;">
                            <div style="font-weight: 600; color: #cda670; width: 140px; flex-shrink: 0; font-family: Georgia, serif;">Email Address:</div>
                            <div style="color: #333333; flex: 1;">' . htmlspecialchars($email) . '</div>
                        </div>
                        
                        <div style="display: flex; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #e8ecf2;">
                            <div style="font-weight: 600; color: #cda670; width: 140px; flex-shrink: 0; font-family: Georgia, serif;">Phone Number:</div>
                            <div style="color: #333333; flex: 1;">' . htmlspecialchars($phone) . '</div>
                        </div>
                        
                        <div style="display: flex; margin-bottom: 15px; padding: 10px 0; border-bottom: 1px solid #e8ecf2;">
                            <div style="font-weight: 600; color: #cda670; width: 140px; flex-shrink: 0; font-family: Georgia, serif;">Service Needed:</div>
                            <div style="color: #333333; flex: 1;">' . htmlspecialchars($service) . '</div>
                        </div>
                    </div>
                    
                    <!-- Message Section -->
                    <div style="margin: 30px 0;">
                        <div style="font-family: Georgia, serif; color: #cda670; font-size: 1.3rem; margin-bottom: 15px;">Client Message:</div>
                        <div style="background: #f5f7fa; padding: 25px; border-radius: 6px; border-left: 4px solid #cda670; margin: 15px 0;">
                            <p style="margin: 0; white-space: pre-line; line-height: 1.8;">' . htmlspecialchars($message) . '</p>
                        </div>
                    </div>
                    
                    <p style="margin-top: 25px; color: #666666;">
                        Please contact <strong style="color: #cda670;">' . htmlspecialchars($name) . '</strong> 
                        at ' . htmlspecialchars($email) . ' or ' . htmlspecialchars($phone) . ' to respond to this consultation request.
                    </p>
                </div>
                
                <!-- Footer -->
                <div style="background: linear-gradient(135deg, #223849, #1b3942); color: #ffffff; padding: 35px 30px; text-align: center;">
                    <div style="font-family: Georgia, serif; font-size: 1.8rem; font-weight: 700; margin-bottom: 15px; color: #cda670;">M. Makgetha <span style="color: #ffffff;">Attorneys Inc.</span></div>
                    <div style="margin: 15px 0; color: #e0d7cb; line-height: 1.8;">
                        <strong>Address:</strong> 136 Peter Mokaba Avenue, Potchefstroom, 2520<br>
                        <strong>Phone:</strong> 079 582 3164 | 018 294 5174 | 018 011 9464<br>
                        <strong>Email:</strong> mmattorneyslaw@telkomsa.net | info@mmakgethaattorneys.com
                    </div>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); color: #e0d7cb; font-size: 0.9rem;">
                        © ' . date('Y') . ' M. Makgetha Attorneys Inc. All Rights Reserved.
                    </div>
                </div>
            </div>
        </body>
        </html>';

        $mail->Body = $formattedMessage;
        $mail->send();

        // Auto-reply to client
        $autoReplyMail = new PHPMailer(true);

        try {
            //Server settings - same as your main email
            $autoReplyMail->isSMTP();
            $autoReplyMail->Host       = 'smtp.gmail.com';
            $autoReplyMail->SMTPAuth   = true;
            $autoReplyMail->Username   = 'neomoremongx@gmail.com';
            $autoReplyMail->Password   = 'pxcosqmpbjlodmyw';
            $autoReplyMail->SMTPSecure = 'ssl';
            $autoReplyMail->Port       = 465;

            //Recipients
            $autoReplyMail->setFrom('neomoremongx@gmail.com', 'M. Makgetha Attorneys Inc.');
            $autoReplyMail->addAddress($email, $name); // Send to the client
            $autoReplyMail->addReplyTo('mmattorneyslaw@telkomsa.net', 'M. Makgetha Attorneys Inc.');

            //Content
            $autoReplyMail->isHTML(true);
            $autoReplyMail->Subject = "Thank You for Your Consultation Request - M. Makgetha Attorneys Inc.";
            
            $autoReplyMessage = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
            </head>
            <body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f7fa;">
                <div style="max-width: 700px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <div style="background: linear-gradient(135deg, #223849, #1b3942); color: #ffffff; padding: 40px 30px; text-align: center;">
                        <h1 style="font-family: Georgia, serif; font-size: 2.2rem; margin: 0 0 15px 0; color: #cda670;">Thank You for Contacting M. Makgetha Attorneys Inc.</h1>
                        <p style="font-size: 1.1rem; margin: 0; color: #e0d7cb; opacity: 0.9;">Expert Legal Assistance & Personalized Consultation</p>
                    </div>
                    
                    <!-- Content -->
                    <div style="padding: 40px 30px; background: #ffffff;">
                        <div style="font-family: Georgia, serif; font-size: 1.5rem; color: #cda670; margin-bottom: 25px; font-weight: 600;">Dear ' . htmlspecialchars($name) . ',</div>
                        
                        <p style="margin-bottom: 20px;">Thank you for reaching out to M. Makgetha Attorneys Inc. We have received your consultation request and our legal team will review your message promptly.</p>
                        
                        <!-- Summary Card -->
                        <div style="background: #f5f7fa; padding: 25px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #cda670;">
                            <div style="font-family: Georgia, serif; color: #cda670; font-size: 1.2rem; margin-top: 0; margin-bottom: 15px;">Your Consultation Summary</div>
                            <p style="margin: 8px 0;"><strong>Service Needed:</strong> ' . htmlspecialchars($service) . '</p>
                            <p style="margin: 8px 0;"><strong>Contact Phone:</strong> ' . htmlspecialchars($phone) . '</p>
                            <p style="margin: 8px 0;"><strong>Submitted:</strong> ' . date('F j, Y \a\t g:i A') . '</p>
                        </div>
                        
                        <!-- Response Time -->
                        <div style="background: linear-gradient(135deg, #cda670, #d4b78a); color: #ffffff; padding: 15px; border-radius: 6px; text-align: center; margin: 20px 0; font-weight: 600;">
                            We typically respond within 24 hours during business days.
                        </div>
                        
                        <!-- Office Info -->
                        <div style="background: #f5f7fa; padding: 25px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #223849;">
                            <div style="font-family: Georgia, serif; color: #cda670; font-size: 1.2rem; margin-top: 0; margin-bottom: 15px;">Office Information</div>
                            <p style="margin: 8px 0;"><strong>Address:</strong> 136 Peter Mokaba Avenue, Potchefstroom, 2520</p>
                            <p style="margin: 8px 0;"><strong>Phone:</strong> 079 582 3164 | 018 294 5174 | 018 011 9464</p>
                            <p style="margin: 8px 0;"><strong>Email:</strong> mmattorneyslaw@telkomsa.net | info@mmakgethaattorneys.com</p>
                            <p style="margin: 8px 0;"><strong>Business Hours:</strong> Monday - Friday: 8:00 AM - 5:00 PM | Saturday: By Appointment</p>
                        </div>
                        
                        <p style="margin-bottom: 20px;">For urgent legal matters, please feel free to call us directly at <strong>079 582 3164</strong>.</p>
                        
                        <p style="margin-bottom: 0;">We look forward to assisting you with your legal needs.<br>
                        <strong>The M. Makgetha Attorneys Inc. Team</strong></p>
                    </div>
                    
                    <!-- Footer -->
                    <div style="background: linear-gradient(135deg, #223849, #1b3942); color: #ffffff; padding: 35px 30px; text-align: center;">
                        <div style="font-family: Georgia, serif; font-size: 1.8rem; font-weight: 700; margin-bottom: 15px; color: #cda670;">M. Makgetha <span style="color: #ffffff;">Attorneys Inc.</span></div>
                        <div style="margin: 15px 0; color: #e0d7cb; line-height: 1.8;">
                            Comprehensive Legal Solutions Tailored to Your Specific Needs<br>
                            Trusted Legal Counsel & Unwavering Support
                        </div>
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); color: #e0d7cb; font-size: 0.9rem;">
                            © ' . date('Y') . ' M. Makgetha Attorneys Inc. All Rights Reserved.
                        </div>
                    </div>
                </div>
            </body>
            </html>';
            
            $autoReplyMail->Body = $autoReplyMessage;
            $autoReplyMail->send();
            
        } catch (Exception $e) {
            // Optional: Log error but don't show to user to avoid confusion
            error_log("Auto-reply failed: " . $autoReplyMail->ErrorInfo);
        }

        echo "
        <script> 
         alert('Thank you " . htmlspecialchars($name) . "! Your consultation request has been sent successfully. We will contact you shortly.');
         document.location.href = 'contact.html';
        </script>
        ";
        
    } catch (Exception $e) {
        // Error message
        echo "
        <script> 
         alert('Sorry, there was an error sending your consultation request. Please try again or contact us directly at 079 582 3164.');
         document.location.href = 'contact.html';
        </script>
        ";
    }
} else {
    // If not a POST request, redirect to contact page
    header("Location: /Makgetha/contact");
    exit;
}
?>