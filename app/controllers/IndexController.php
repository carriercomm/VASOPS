<?php
class IndexController extends BaseController {

/**
* Make the index view
*/
public function get_index()
{
    $fname = "";
    if (Auth::check()) {
        $fname = User::getFirstName(Auth::user()->get()->cid);
    }

    //Pull category data
    $categories = Category::get();
    //Figure out which categories have children
    $categoryChildren = array();
    foreach ($categories as $categoryParent) {
        if (Category::isParent($categoryParent->id)) {
            $categoryChildren[$categoryParent->id] = Category::getChildren($categoryParent->id);
        }
    }

    return View::make('index')->with(array('fname' => $fname, 'categories' => $categories, 'categoryChildren' => $categoryChildren));
}

}