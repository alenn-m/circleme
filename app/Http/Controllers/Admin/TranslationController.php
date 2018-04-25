<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use File;
use Illuminate\Http\Request;
use Input;
use Redirect;
use URL;
use View;

class TranslationController extends Controller {

	public function front(){

        $control = File::getRequire(base_path()."/resources/lang/control/front.php");
        $lang = File::getRequire(base_path()."/resources/lang/en/front.php");

        return View::make("admin.translation.front", compact("control", "lang"));
    }

    public function storeFront(){
        $lang = File::getRequire(base_path()."/resources/lang/control/front.php");

        foreach(Input::except("_method", "_token", "_page") as $key => $value){

            if(count(explode("-", $key)) == 1){
                if(!is_empty($value)){
                    $lang[$key] = $value;
                }else{
                    $lang[$key] = "";
                }
            }else{
                $key1 = explode("-", $key);
                if(!is_empty($value)){
                    $lang[$key1[0]][$key1[1]] = $value;
                }
            }
        }

        $data = var_export($lang, true);

        \Artisan::call("js-localization:refresh");

        \Session::flash("message", trans("admin.translationSaved"));

        if(File::put(base_path()."/resources/lang/en/front.php", "<?php\n return $data;")){
            return Redirect::back();
        }
    }

    public function admin(){
        $control = File::getRequire(base_path()."/resources/lang/control/admin.php");
        $lang = File::getRequire(base_path()."/resources/lang/en/admin.php");

        return View::make("admin.translation.admin", compact("control", "lang"));
    }

    public function storeAdmin(){
        $lang = File::getRequire(base_path()."/resources/lang/en/admin.php");

        foreach(Input::except("_method", "_token", "_page") as $key => $value){

            if(count(explode("-", $key)) == 1){
                if(!is_empty($value)){
                    $lang[$key] = $value;
                }else{
                    $lang[$key] = "";
                }
            }else{
                $key1 = explode("-", $key);
                if(!is_empty($value)){
                    $lang[$key1[0]][$key1[1]] = $value;
                }
            }
        }

        $data = var_export($lang, true);

        \Session::flash("message", trans("admin.translationSaved"));

        if(File::put(base_path()."/resources/lang/en/admin.php", "<?php\n return $data;")){
            return Redirect::back();
        }
    }

    public function validation(){
        $control = File::getRequire(base_path()."/resources/lang/control/validation.php");
        $lang = File::getRequire(base_path()."/resources/lang/en/validation.php");

        return View::make("admin.translation.validation", compact("control", "lang"));
    }

    public function storeValidation(){
        $lang = File::getRequire(base_path()."/resources/lang/en/validation.php");

        foreach(Input::except("_method", "_token", "_page") as $key => $value){

            if(count(explode("-", $key)) == 1){
                if(!is_empty($value)){
                    $lang[$key] = $value;
                }else{
                    $lang[$key] = "";
                }
            }else{
                $key1 = explode("-", $key);
                if(!is_empty($value)){
                    $lang[$key1[0]][$key1[1]] = $value;
                }
            }
        }

        $data = var_export($lang, true);

        \Session::flash("message", trans("admin.translationSaved"));

        if(File::put(base_path()."/resources/lang/en/validation.php", "<?php\n return $data;")){
            return Redirect::back();
        }
    }

}
