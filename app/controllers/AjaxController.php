<?php
class AjaxController extends BaseController {

    public function post_registration()
    {
        //Pull our AJAX post data
        $postStr = Input::get('data');
        //Parse the serialized string
        parse_str($postStr, $post);
        //Laravel gets made and throws an error if category isn't defined so let's go ahead and just define it but leave it empty.
        if (empty($post['inputCategory'])) {
            $post['inputCategory'] = '';
        }
        //Format our URL field with the http before if it isn't there already
        if (!strpos($post['inputUrl'],'http://') AND !strpos($post['inputUrl'],'https://')) {
            $post['inputUrl'] = 'http://' . $post['inputUrl'];
        }

        //Start our validator
        $validator = Validator::make(
            array(
                'Va Name' => $post['inputVaName'],
                'Url' => $post['inputUrl'],
                'Description' => $post['inputDescription'],
                'Vatsim Image Page Link' => $post['inputVatsimImagePageLink'],
                'Country' => $post['inputCountry'],
                'State/Province' => $post['inputStateProvince'],
                'City' => $post['inputCity'],
                'Zip' => $post['inputZip'],
                'Name' => $post['inputName'],
                'Email' => $post['inputEmail'],
                'Password' => $post['inputPassword'],
                'Password_confirmation' => $post['inputPassword_confirmation'],
                'Category' => $post['inputCategory'],
            ),
            array(
                'Va Name' => 'required',
                'Url' => 'required|url',
                'Description' => 'required|max:200',
                'Vatsim Image Page Link' => 'required|url',
                'Country' => 'required',
                'State/Province' => 'required',
                'City' => 'required',
                'Zip' => 'required',
                'Name' => 'required',
                'Email' => 'required|email',
                'Password' => 'required|min:6|confirmed',
                'Password_confirmation' => 'required|min:6',
                'Category' => 'required',
            )
        );

        if ($validator->fails())
        {
            // The given data did not pass validation
            $messages = $validator->messages();
            $errorStr = '';
            foreach ($messages->all('<li>:message</li>') as $message)
            {
                $errorStr .= '<div class="alert alert-error">'. $message . '</div>';
            }
            echo $errorStr;

        }
        else {
            //Submit Data


        }

    }

}