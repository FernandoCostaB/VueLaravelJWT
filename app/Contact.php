<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $phone_number
 * @property string $name
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Contact extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['phone_number', 'name', 'user_id', 'created_at', 'updated_at'];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function create(Request $request) {
        $contact = new Contact();
        $contact->user_id = $request->User()->id;
        $contact->phone_number = $request->get('phone_number');
        $contact->name = $request->get('name');
        $contact->save();
        return $contact;
    }
    public static function updateOne(Request $request) {
        $contact = Contact::where('id',$request->get('id'))->first();
        $contact->phone_number = $request->get('phone_number');
        $contact->name = $request->get('name');
        $contact->save();
        return $contact;
    }
    public static function deleteOne(Request $request) {
        Contact::where('id',$request->get('id'))->delete();
    }
    public static function readAll(Request $request) {
        return Contact::where('user_id',$request->User()->id)->get();
    }
}
