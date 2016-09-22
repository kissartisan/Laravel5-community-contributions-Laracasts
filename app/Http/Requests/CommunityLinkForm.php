<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommunityLinkForm extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel_id' => 'required|exists:channels,id', // Channel ID should exist in the channels table with the column on ID
            'title' => 'required',
            'link' => 'required|active_url' // |unique:community_links
        ];
    }
}
