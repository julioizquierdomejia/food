<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notitication;
use App\Models\User;
use App\Models\UsersMovilModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $items = Notitication::all();
        return view('admin.notifications.index', compact('items'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Notitication::rules());
        $data = $request->all();
        Notitication::create($data);

        return back()->withSuccess(trans('app.success_store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id): View
    {
        $item = Notitication::findOrFail($id);

        return view('admin.notifications.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, Notitication::rules(true, $id));

        $item = Notitication::findOrFail($id);
        $data = $request->all();
        $item->update($data);

        return redirect()->route(ADMIN . '.notifications.index')
            ->withSuccess(trans('app.success_update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notitication::destroy($id);

        return back()->withSuccess(trans('app.success_destroy'));
    }

    /**
     * notify
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function notify(Request $request)
    {
        $notification = Notitication::find($request->notification_id);
        if ($notification) {
            $users = User::all();
            foreach ($users as $user) {
                $this->sendNotification($user->iduser, 'Mas Latinos Notification', $notification->name);
            }
        }

        return back()->withSuccess(trans('app.success_destroy'));
    }

    public function sendNotification($iduser, $title, $body)
    {
        try {
            $url = 'https://fcm.googleapis.com/fcm/send';
            $DeviceToken = User::whereNotNull('device_token')->where('idusers', '=', $iduser)->select('device_token')->get()->first();
            if ($DeviceToken == null) {
                return -1;
            }
            $FcmKey = 'AAAAPLUq2jU:APA91bGfVy9Jq2aFAo9DMjgbcXiKrFZj2eox1AIVo0cnkDp3F7GGVI8WoU-G6SK6aqUFwyU5l83nF8tgWAeZJoEA9jkEk_fW3i2LYEO5QNEbkH-V7ucPfqZr9EBEvk_nw2wT60pZ4Fsz';

            $data = [
                "registration_ids" => [$DeviceToken->device_token],
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "image" => "https://img.freepik.com/vector-gratis/ilustracion-concepto-notificaciones-push_114360-4850.jpg?size=338&ext=jpg",
                    "sound" => "default"
                ],
                "data" => [
                    "click_action" => "FLUTTER_NOTIFICATION_CLICK"
                ]
            ];
            $RESPONSE = json_encode($data);
            $headers = [
                'Authorization:key=' . $FcmKey,
                'Content-Type: application/json',
            ];
            // CURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $RESPONSE);

            $output = curl_exec($ch);
            if ($output === FALSE) {
                die('Curl error: ' . curl_error($ch));
            }
            curl_close($ch);
            return 1;
        } catch (\Throwable $th) {
            return -1;
        }
    }
}
