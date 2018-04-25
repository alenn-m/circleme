<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Config;
use File;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;
use URL;
use View;

class SettingsController extends Controller {


    /**
     * Show settings - basic page
     * @return \Illuminate\View\View
     */
    public function index()
	{
		return View::make("admin.settings.index");
	}

    public function storeServices(){
        $array = Config::get("services");

        foreach(Input::except("_token") as $key => $value){
            if(strpos($key, "-")){
                $split = explode("-", $key);
                $array[$split[0]][$split[1]] = $value;
            }
        }

        $data = var_export($array, true);

        $d = Config::get("recaptcha");

        $d["siteKey"] = Input::get("siteKey");
        $d["secretKey"] = Input::get("secretKey");

        $d = var_export($d, true);

        File::put(base_path() . "/config/recaptcha.php", "<?php\n return $d;");

        $a = Config::get("settings");
        $a["tracking_code"] = Input::get("tracking_code");
        $a["addthis_code"] = Input::get("addthis_code");
        $a = var_export($a, true);
        File::put(base_path() . "/config/settings.php", "<?php\n return $a;");

        if(File::put(base_path() . "/config/services.php", "<?php\n return $data;")){
            return Redirect::back()->with("message", trans("front.settingsSaved"));
        }else{
            return Redirect::back()->withInput();
        }
    }

    /**
     * Store admin settings
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(){
        $array = Config::get("settings");

        foreach(Input::except("_token", "use_text") as $key => $value){
            $array[$key] = $value;
        }

        if(Input::file("logo")){
            $file = Input::file('logo');
            $destinationPath = public_path() . '/uploads';
            $extension = $file->getClientOriginalExtension();
            $filename = str_random(12) . "." . $extension;

            $file->move($destinationPath, $filename);

            $array["logo"] = $filename;
        }

        if(Input::get("use_text")){
            $array["logo"] = "";
        }

        $data = var_export($array, true);

        if(File::put(base_path() . "/config/settings.php", "<?php\n return $data ;")){
            return Redirect::back()->with("message", trans("front.settingsSaved"));
        }else{
            return Redirect::back()->withInput();
        }
    }

    public function storeEmail(){
        $data["driver"] = Input::get("driver");
        $data["from"]["address"] = Input::get("address");
        $data["from"]["name"] = Input::get("name");
        $data["sendmail"] = "/usr/sbin/sendmail -bs";
        $data["pretend"] = false;

        $data = var_export($data, true);
        $file1 = File::put(base_path() . "/config/mail.php", "<?php\n return $data ;");

        $data1["mandrill"]["secret"] = Input::get("mandril_api");

        $data1 = var_export($data1, true);
        $file2 = File::put(base_path() . "/config/services.php", "<?php\n return $data1 ;");

        if($file1 && $file2){
            return Redirect::back()->with("message", trans("front.settingsSaved"));
        }else{
            return Redirect::back()->withInput();
        }
    }

    /**
     * Show settings - ads page
     * @return \Illuminate\View\View
     */
    public function getAds(){
        return View::make("admin.settings.ads");
    }

    /**
     * Show settings - email page
     * @return \Illuminate\View\View
     */
    public function getEmailSettings(){
        return View::make("admin.settings.email");
    }

    /**
     * Show settings - services page
     * @return \Illuminate\View\View
     */
    public function getServices(){
        return View::make("admin.settings.services");
    }

    public function getPredefinedEmail(){
        $confirmEmail = File::get(base_path() . "/resources/views/emails/confirmEmail.blade.php");
        $contact = File::get(base_path() . "/resources/views/emails/contact.blade.php");
        $forgotPassword = File::get(base_path() . "/resources/views/emails/forgotPassword.blade.php");
        $invite = File::get(base_path() . "/resources/views/emails/invite.blade.php");
        $validateEmail = File::get(base_path() . "/resources/views/emails/validateEmail.blade.php");

        return View::make("admin.settings.predefined", compact("confirmEmail", "contact", "forgotPassword", "invite", "validateEmail"));
    }

    public function storePredefinedEmail(){
        $confirmEmail = Input::get("confirmEmail");
        $contact = Input::get("contact");
        $forgotPassword = Input::get("forgotPassword");
        $invite = Input::get("invite");
        $validateEmail = Input::get("validateEmail");

        if(!is_empty($confirmEmail)){
            File::put(base_path() . "/resources/views/emails/confirmEmail.blade.php", $confirmEmail);
        }

        if(!is_empty($contact)){
            File::put(base_path() . "/resources/views/emails/contact.blade.php", $contact);
        }

        if(!is_empty($forgotPassword)){
            File::put(base_path() . "/resources/views/emails/forgotPassword.blade.php", $forgotPassword);
        }

        if(!is_empty($invite)){
            File::put(base_path() . "/resources/views/emails/invite.blade.php", $invite);
        }

        if(!is_empty($validateEmail)){
            File::put(base_path() . "/resources/views/emails/validateEmail.blade.php", $validateEmail);
        }

        Session::flash("message", trans("admin.saved"));
        return Redirect::to(URL::action("Admin\SettingsController@getPredefinedEmail"));
    }

}
