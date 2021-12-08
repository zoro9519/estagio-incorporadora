<?php

namespace App\Http\Controllers;

use App\Mail\RegistroNewsletter;
use App\Models\Loteamento;
use App\Models\NewsletterMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsletterMember  $newsletterMember
     * @return \Illuminate\Http\Response
     */
    public function show(NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsletterMember  $newsletterMember
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsletterMember  $newsletterMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsletterMember  $newsletterMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsletterMember $newsletterMember)
    {
        //
    }

    public function registerMember(Loteamento $loteamento, Request $request)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        $data = $request->input();

        $userSearch = User::where("email", $data['email'])->first() ?? [];
        $user = $userSearch;

        if(empty($userSearch)){
            $user = new User();

            $user->nome = $data['nome'];
            $user->email = $data['email'];
            $user->password = Hash::make(substr($data['email'], 0, 6));
            $user->status = User::STATUS_EMESPERA;

            $user->save();
        }

        $memberSearch = $loteamento->interessados()->where("user_id", $user->id)->first();

        if(empty($memberSearch)){

            $loteamento->interessados()->attach($user->id, [
                'interests' => isset($data['interests']) ? "A" : "L"
            ]);
            
            Mail::to($user->email)->send(new RegistroNewsletter($user, $loteamento, $data));

            $return['message'][] = "Parabéns, consulte seu email para maiores informações";
            $return['success'] = true;
        } else{
            $return['message'][] = "Conta já cadastrada na newsletter";
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect(route('landing.view', ['loteamento' => $loteamento->link]))->with("return", $return);
    }
}
