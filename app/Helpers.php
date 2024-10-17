<?php

use App\Models\Color;
use App\Models\GeneralInfo;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;

function openJSONFile($code){
    $jsonString = [];
    if(File::exists(base_path('resources/lang/'.$code.'.json'))){
        $jsonString = file_get_contents(base_path('resources/lang/'.$code.'.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}
function saveJSONFile($code, $data){
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/'.$code.'.json'), stripslashes($jsonData));
}
function get_general_value($key)
{
    $general = GeneralInfo::where('key', $key)->first();
    if ($general) {
        return $general->value;
    }

    return '';
}
function get_product_imge($id){
$pro = Product::find($id);
return @$pro->colors()->first()->front_image; 

}
function get_color($id){
    $color = Color::find($id);
    return $color->name;
}
function get_color_code($id){
    $color = Color::find($id);
    return $color->code;
}

 function addToJsonFile($name)
{
    // Validate the request
    

    // Set the language file path. Adjust 'en' if you're using another locale like 'ar'
    $locale = 'en';  // or 'ar', based on the localization you're targeting
    $filePath = resource_path("lang/{$locale}.json");

    // Check if the file exists
    if (File::exists($filePath)) {
        // Read the file content and decode the JSON into a PHP array
        $jsonContent = json_decode(File::get($filePath), true);

        // Add the new key-value pair to the array
        $jsonContent[$name] = $name;

        // Encode the array back into JSON format and save it to the file
        File::put($filePath, json_encode($jsonContent, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        translatefile($name);
        return response()->json(['success' => 'Name added to the JSON file successfully!']);
    }

    return response()->json(['error' => 'Language file not found!'], 404);
}
function translatefile($name){
    $tr = new GoogleTranslate();
    $targetLang = 'ar';

    $translatedText = $tr->setTarget($targetLang)->translate($name);
    $locale = 'ar';  // or 'ar', based on the localization you're targeting
    $filePath = resource_path("lang/{$locale}.json");

    // Check if the file exists
    if (File::exists($filePath)) {
        // Read the file content and decode the JSON into a PHP array
        $jsonContent = json_decode(File::get($filePath), true);

        // Add the new key-value pair to the array
        $jsonContent[$name] = $translatedText;

        // Encode the array back into JSON format and save it to the file
        File::put($filePath, json_encode($jsonContent, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->json(['success' => 'Name added to the JSON file successfully!']);
    }

    return response()->json(['error' => 'Language file not found!'], 404);

}
?>