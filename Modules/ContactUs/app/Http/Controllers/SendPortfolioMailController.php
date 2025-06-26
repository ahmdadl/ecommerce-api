<?php

namespace Modules\ContactUs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\ContactUs\Emails\PortfolioMail;

class SendPortfolioMailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|max:100",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "message" => $validator->messages()->first(),
                ],
                422
            );
        }

        sendMail("ahmdadl.dev@gmail.com", new PortfolioMail($request->email));

        return response()->json([
            "message" => "Mail sent successfully",
        ]);
    }
}
