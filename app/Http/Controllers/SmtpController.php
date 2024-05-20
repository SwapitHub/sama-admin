<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Validator;
	use App\Models\SmtpModel;
	
	class SmtpController extends Controller
	{
		public function index()
		{
			$data['smtp'] = SmtpModel::first();
			return view('admin.smtp',$data);	
		}
		
		public function updateSmtp(Request $request)
		{
			$smtp = SmtpModel::find(1);
			$this->validate($request, [
            'name' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required', 
			], [
            'name.required' => 'The smtp name field is required.',
            'host.required' => 'The smtp host field is required.',
            'port.required' => 'The smtp port field is required',
            'username.required' => 'The smtp username field is required',
            'password.required' => 'The smtp password field is required ',
			]);
			$smtp->name = $request->name;
			$smtp->host = $request->host;
			$smtp->port = $request->port;
			$smtp->username = $request->username;
			$smtp->password = $request->password;
			$smtp->encryption = $request->encryption;
			$smtp->save();
			return redirect()->back()->with('success', 'Smtp details updated successfully');
		}
	}
