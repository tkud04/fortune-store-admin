<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\Contracts\HelperContract; 
use Auth;
use Session; 
use Cookie;
use Validator; 
use Carbon\Carbon;
use App\User; 
//use Codedge\Fpdf\Fpdf\Fpdf;
use PDF;

class MainController extends Controller {

	protected $helpers; //Helpers implementation
    
    public function __construct(HelperContract $h)
    {
    	$this->helpers = $h;                      
    }

	
	/**
	 * Show the application home page.
	 *
	 * @return Response
	 */
	public function getIndex(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$v = "index";
				$orders = $this->helpers->getOrders();
				$stats = $this->helpers->getSiteStats();
				$tph = []; $plans = []; $tips = [];
				#dd($stats);
				$req = $request->all();
                array_push($cpt,'orders');				
                array_push($cpt,'stats');					
                array_push($cpt,'tph');					
                array_push($cpt,'plans');					
                array_push($cpt,'tips');					
			}
			else
			{
				$u = "http://themobilebuzz.co.uk";
				return redirect()->away($u);
			}
		}
		else
		{
			$v = "login";
		}
		
		return view($v,compact($cpt));
		
    }
	
	
	/**
	 * Show list of registered users on the platform.
	 *
	 * @return Response
	 */
	public function getUsers(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "users";
				$req = $request->all();
                $users = $this->helpers->getUsers();
				#dd($users);
                array_push($cpt,'users');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show details of a registered user on the platform.
	 *
	 * @return Response
	 */
	public function getUser(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				if(isset($req['xf']))
				{
					$xf = $req['xf'];
					$v = "user";
					$uu = User::where('id',$xf)
					          ->orWhere('email',$xf)->first();
							  
					if($uu == null)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
				    $u = $this->helpers->getUser($xf);
					
					if(count($u) < 1)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
					else
					{
						$users = [];
						$apts = $this->helpers->getApartments($uu);
					    $reviews = $this->helpers->getReviews($uu->id,"user");
					    $permissions = $this->helpers->getPermissions($uu);
						#dd(count($reviews));
                        array_push($cpt,'u');
                        array_push($cpt,'apts');
                        array_push($cpt,'reviews');
                        array_push($cpt,'users');
                        array_push($cpt,'permissions');
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('users');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update user.
	 *
	 * @return Response
	 */
	public function postUser(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				$validator = Validator::make($req,[
		                    'fname' => 'required',
		                    'lname' => 'required',
		                    'phone' => 'required|numeric',
		                    'email' => 'required|email',
		                    'role' => 'required|not_in:none',
		                    'status' => 'required|not_in:none'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateUser($req);
					$ss = "update-user-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->back();
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle Enable/Disable user.
	 *
	 * @return Response
	 */
	public function getEnableDisableUser(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
		                    'type' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateEDU($req);
					$ss = "update-user-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->back();
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show the Add Permission view.
	 *
	 * @return Response
	 */
	public function getAddPermission(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$xf = $req['xf'];
					$v = "add-permissions";
					$uu = User::where('id',$xf)
					          ->orWhere('email',$xf)->first();
							  
					if($uu == null)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
				    $u = $this->helpers->getUser($xf);
					
					if(count($u) < 1)
					{
						session()->flash("invalid-user-status-error","ok");
						return redirect()->intended('users');
					}
					else
					{
						array_push($cpt,'u');                       
						array_push($cpt,'permissions');                       
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('users');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add permission.
	 *
	 * @return Response
	 */
	public function postAddPermission(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'pp' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$pp = json_decode($req['pp']);
					$ptags = [];
					
					foreach($pp as $p)
					{
						if($p->selected) array_push($ptags,$p->ptag);
					}
					
					$dt = [
					     'xf' => $req['xf'],
					     'ptags' => $ptags,
					     'granted_by' => $user->id
					   ];
					   
					$ret = $this->helpers->addPermissions($dt);
					$ss = "add-permissions-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("user?xf=".$req['xf']);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle remove permission.
	 *
	 * @return Response
	 */
	public function getRemovePermission(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'p' => 'required',
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removePermission($req);
					  $ss = "remove-permission-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("user?xf=".$req['xf']);
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of reviews.
	 *
	 * @return Response
	 */
	public function getReviews(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "reviews";
				$req = $request->all();
                $reviews = $this->helpers->getAllReviews();
				#dd($reviews);
                array_push($cpt,'reviews');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle approve/reject review.
	 *
	 * @return Response
	 */
	public function getApproveRejectReview(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews','edit_reviews']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'type' => 'required',
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $dt = ['id' => $req['xf'],'status' => ""];
					  $dt['status'] = $req['type'] == "approve" ? "approved" : "rejected";
					  $ret = $this->helpers->updateReviewStatus($dt);
					  
					  $ss = "update-review-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("reviews");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle remove review.
	 *
	 * @return Response
	 */
	public function getRemoveReview(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_reviews','edit_reviews']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeReview($req);
					  $ss = "remove-review-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("reviews");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of plugins.
	 *
	 * @return Response
	 */
	public function getPlugins(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "plugins";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Plugin view.
	 *
	 * @return Response
	 */
	public function getAddPlugin(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-plugin";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add plugin.
	 *
	 * @return Response
	 */
	public function postAddPlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'status' => 'required|not_in:none',
                             'name' => 'required',
                             'value' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->createPlugin($req);
					$ss = "add-plugin-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("plugins");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show the Edit Plugin view.
	 *
	 * @return Response
	 */
	public function getPlugin(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['s']))
				{
					$v = "plugin";
					$p = $this->helpers->getPlugin($req['s']);
					
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('plugins');
					}
					else
					{
						array_push($cpt,'p');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('plugins');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle edit plugin.
	 *
	 * @return Response
	 */
	public function postPlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'status' => 'required|not_in:none',
                             'xf' => 'required|numeric',
                             'name' => 'required',
                             'value' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updatePlugin($req);
					$ss = "update-plugin-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("plugins");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove plugin.
	 *
	 * @return Response
	 */
	public function getRemovePlugin(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    's' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removePlugin($req['s']);
					  $ss = "remove-plugin-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("plugins");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
  /**
	 * Show the Add Sender view.
	 *
	 * @return Response
	 */
	public function getAddSender(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
       
	   
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "add-sender";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
		
    }
	
	/**
	 * Handle add sender.
	 *
	 * @return Response
	 */
	public function postAddSender(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				  #dd($req);
				
				  $validator = Validator::make($req,[
                    'server' => 'required|not_in:none',
                    'name' => 'required',
                    'username' => 'required'
		                   ]);
						
				 if($validator->fails())
                 {
                   session()->flash("validation-status-error","ok");
			       return redirect()->back()->withInput();
                 }
				 else
				 {
		         	$dt = ['type' => $req['server'],'sn' => $req['name'],'su' => $req['username'],'spp' => $req['password']];
         
					 if($req['server'] == "other")
					 {
						$v = isset($req['ss']) && isset($req['sp']) && isset($req['sec']) && $req['sec'] != "nonee";
						if($v)
						{
							$dt['ss'] = $req['ss'];
							$dt['sp'] = $req['sp'];
							$dt['sec'] = $req['sec'];
						}
						else
						{
							session()->flash("validation-status-error", "success"); 
							return redirect()->back()->withInput();
						}
					 }
					else
		            {
		            	$smtp = $this->helpers->smtpp[$req['server']];
		                $dt['ss'] = $smtp['ss'];
							$dt['sp'] = $smtp['sp'];
							$dt['sec'] = $smtp['sec'];
		            }
            
		            $dt['se'] = $dt['su'];
		            $dt['sa'] = "yes";
		            $dt['current'] = "no";
		            $ret = $this->helpers->createSender($dt);
					$ss = "add-sender-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("senders");
				 }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
    
         /**
	 * Show the Senders view.
	 *
	 * @return Response
	 */
	 	public function getSenders(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$senders = $this->helpers->getSenders();
						array_push($cpt,'senders');
	 				    $v = "senders";
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
         /**
	 * Show the Sender view.
	 *
	 * @return Response
	 */
	 	public function getSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $s = $this->helpers->getSender($req['s']);
						   array_push($cpt,'s');
	 				       $v = "sender";
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
		 
	 	/**
	 	 * Handle update sender.
	 	 *
	 	 * @return Response
	 	 */
	 	public function postSender(Request $request)
	     {
	 		$user = null;
	 		if(Auth::check())
	 		{
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
				
	 				  #dd($req);
				
	 				  $validator = Validator::make($req,[
	                     'server' => 'required|not_in:none',
	                     'name' => 'required',
	                     'username' => 'required'
	 		                   ]);
						
	 				 if($validator->fails())
	                  {
	                    session()->flash("validation-status-error","ok");
	 			       return redirect()->back()->withInput();
	                  }
	 				 else
	 				 {
	 		         	$dt = ['type' => $req['server'],'sn' => $req['name'],'su' => $req['username'],'spp' => $req['password']];
         
	 					 if($req['server'] == "other")
	 					 {
	 						$v = isset($req['ss']) && isset($req['sp']) && isset($req['sec']) && $req['sec'] != "nonee";
	 						if($v)
	 						{
	 							$dt['ss'] = $req['ss'];
	 							$dt['sp'] = $req['sp'];
	 							$dt['sec'] = $req['sec'];
	 						}
	 						else
	 						{
	 							session()->flash("validation-status-error", "success"); 
	 							return redirect()->back()->withInput();
	 						}
	 					 }
	 					else
	 		            {
	 		            	$smtp = $this->helpers->smtpp[$req['server']];
	 		                $dt['ss'] = $smtp['ss'];
	 							$dt['sp'] = $smtp['sp'];
	 							$dt['sec'] = $smtp['sec'];
	 		            }
            
	 		            $dt['se'] = $dt['su'];
	 		            $dt['sa'] = "yes";
	 		            $dt['current'] = "no";
	 		            $ret = $this->helpers->createSender($dt);
	 					$ss = "add-sender-status";
	 					if($ret == "error") $ss .= "-error";
	 					session()->flash($ss,"ok");
	 			        return redirect()->intended("senders");
	 				 }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended("/");
	 				}
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			return redirect()->intended('/');
	 		}
	     }
		 
		 
         /**
	 * Handle Remove Sender.
	 *
	 * @return Response
	 */
	 	public function getRemoveSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $this->helpers->removeSender($req['s']);
   	 					   $ss = "remove-sender-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("senders");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
		 
		 
         /**
	 * Handle Remove Sender.
	 *
	 * @return Response
	 */
	 	public function getMarkSender(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_senders','edit_senders']);
	 				#dd($hasPermission);
	 				$req = $request->all();
				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						
				        $validator = Validator::make($req, [                          
				                             's' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('senders');
				         }
						else
						{
						   $this->helpers->setAsCurrentSender($req['s']);
   	 					   $ss = "mark-sender-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("senders");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
	
	
	/**
	 * Show list of transactions on the platform.
	 *
	 * @return Response
	 */
	public function getTransactions(Request $request)
    {
	    return redirect()->intended("finance");
    }
	
	/**
	 * Show list of transactions on the platform.
	 *
	 * @return Response
	 */
	public function getFinance(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "transactions";
				$req = $request->all();
                $transactions = $this->helpers->getAllTransactions();
				#dd($transactions);
                array_push($cpt,'transactions');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the Communications view.
	 *
	 * @return Response
	 */
	public function getCommunication(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "communication";
				$req = $request->all();
                $dt = $this->helpers->getCommunicationData();
				#dd($dt);
                array_push($cpt,'dt');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Redirect
	 *
	 * @return Response
	 */
	public function getSendMessage(Request $request)
    {
		return redirect()->intended('communication');
    }
	
	/**
	 * Redirect
	 *
	 * @return Response
	 */
	public function postSendMessage(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				    $req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'xf' => 'required',
				                             'type' => 'required',
				                             'message' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
							  session()->flash("validation-status-error","ok");
				         	return redirect()->intended('senders');
				         }
						else
						{
						    $r = $this->helpers->sendMessage($req);
			                $ret = "send-message-status";
			                if($r == "error") $ret .= "-error";
			                session()->flash($ret,"ok");
			                return redirect()->intended('communication');
					    }
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show list of top performing hosts on the platform.
	 *
	 * @return Response
	 */
	public function getTopPerformingHosts(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "tph";
				$req = $request->all();
                $tph = $this->helpers->getTopPerformingHosts();
				$tph = $tph->all();
				#dd($hs);
                array_push($cpt,'tph');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the View Transaction view.
	 *
	 * @return Response
	 */
	public function getTransaction(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_transactions','edit_transactions']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "transaction";
					$t = $this->helpers->getTransaction($req['xf'],['guest' => true]);
					#dd($t);
					if(count($t) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('transactions');
					}
					else
					{
						array_push($cpt,'t');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('transactions');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the Add Product view.
	 *
	 * @return Response
	 */
	public function getAddProduct(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				  $v = "add-product";
				  $manufacturers = $this->helpers->getManufacturers();
				  $categories = $this->helpers->getCategories();
				  array_push($cpt,'manufacturers');
				  array_push($cpt,'categories');
			 	  $req = $request->all();
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add product.
	 *
	 * @return Response
	 */
	public function postAddProduct(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				$ret = ['status' => "error",'message' => "nothing happened"];
				
				if($hasPermission)
				{
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'name' => 'required',
		                    'meta_title' => 'required|unique:product_data',
		                    'model' => 'required',
		                    'category' => 'required|not_in:none',
		                    'manufacturer' => 'required|not_in:none',
		                    'status' => 'required|not_in:none',
		                   ]);
						
				if($validator->fails())
                {
                  $ret['message'] = "validation";
                }
				else
				{
					$ird = [];
                    $networkError = false;
				    
					$iv = (isset($req['img_count']) && $req['img_count'] > 0 && isset($req['cover']));
					if($iv)
					{
                    for($i = 0; $i < $req['img_count']; $i++)
                    {
            		  $img = $request->file("ap-image-".$i);
					  if($img != null)
					  {
					     $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					     if(isset($imgg['status']) && $imgg['status'] == "error")
					     {
						   $networkError = true;
						   break;
					     }
					     else
					     {
						   $ci = ($req['cover'] != null && $req['cover'] == $i) ? "yes": "no";
					       $temp = [
					         'public_id' => $imgg['public_id'],
					         'delete_token' => $imgg['delete_token'],
					         'deleted' => "no",
					         'ci' => $ci,
						     'type' => "image"
						   ];
			               array_push($ird, $temp);  
					    }
					 } 
                      										
					}
					}
					
					if($networkError)
					{
						$ret['message'] = "network";
					}
					else
					{
						$req['user_id'] = "admin";
					    $req['ird'] = $ird;
					    $this->helpers->addProduct($req);
			             $ret = ['status' => "ok"];
					}
				 }
				 return json_encode($ret);
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of products on the platform.
	 *
	 * @return Response
	 */
	public function getProducts(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "products";
				$req = $request->all();
                $products = $this->helpers->getProducts();
				#dd($products);
                array_push($cpt,'products');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the View Product view.
	 *
	 * @return Response
	 */
	public function getProduct(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "product";
					$p = $this->helpers->getProduct($req['xf'],['host' => true,'imgId' => true]);
					#dd($p);
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('products');
					}
					else
					{
						 $manufacturers = $this->helpers->getManufacturers();
				         $categories = $this->helpers->getCategories();
				         array_push($cpt,'manufacturers');
				         array_push($cpt,'categories');
						 array_push($cpt,'p');                                 
					}
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('products');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle update product.
	 *
	 * @return Response
	 */
	public function postProduct(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				$ret = ['status' => "error",'message' => "nothing happened"];
				
				if($hasPermission)
				{
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
		                    'name' => 'required',
		                    'meta_title' => 'required',
		                    'model' => 'required',
		                    'category' => 'required|not_in:none',
		                    'manufacturer' => 'required|not_in:none',
		                    'status' => 'required|not_in:none',
		                   ]);
						
				if($validator->fails())
                {
                  $ret['message'] = "validation";
                }
				else
				{
					$ird = [];
                    $networkError = false;
				    
					$iv = (isset($req['img_count']) && $req['img_count'] > 0 && isset($req['cover']));
					if($iv)
					{
                    for($i = 0; $i < $req['img_count']; $i++)
                    {
            		  $img = $request->file("ap-image-".$i);
					  if($img != null)
					  {
					     $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					     if(isset($imgg['status']) && $imgg['status'] == "error")
					     {
						   $networkError = true;
						   break;
					     }
					     else
					     {
						   $ci = ($req['cover'] != null && $req['cover'] == $i) ? "yes": "no";
					       $temp = [
					         'public_id' => $imgg['public_id'],
					         'delete_token' => $imgg['delete_token'],
					         'deleted' => "no",
					         'ci' => $ci,
						     'type' => "image"
						   ];
			               array_push($ird, $temp);  
					    }
					 } 
                      										
					}
					}
					
					if($networkError)
					{
						$ret['message'] = "network";
					}
					else
					{
						$req['user_id'] = "admin";
					    $req['ird'] = $ird;
					    $this->helpers->updateProduct($req);
			             $ret = ['status' => "ok"];
					}
				 }
				 return json_encode($ret);
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	 /**
	 * Handle Remove Product.
	 *
	 * @return Response
	 */
	 	public function getRemoveProduct(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
	 				#dd($hasPermission);
	 				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'xf' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('products');
				         }
						else
						{
						   $this->helpers->removeProduct($req['xf']);
   	 					   $ss = "remove-product-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("products");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }

    /**
	 * Handle Update Apartment Status.
	 *
	 * @return Response
	 */
	 	public function getUpdateProductStatus(Request $request)
	     {
	 		$user = null;
	 		$nope = false;
	 		$v = "";
		
	 		$signals = $this->helpers->signals;
	 		$plugins = $this->helpers->getPlugins();
	 		$cpt = ['user','signals','plugins'];
       
	   
	 		if(Auth::check())
	 		{
			
	 			$user = Auth::user();
			
	 			if($this->helpers->isAdmin($user))
	 			{
	 				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
	 				#dd($hasPermission);
	 				
	 				if($hasPermission)
	 				{
						$req = $request->all();
						#dd($req);
				        $validator = Validator::make($req, [                          
				                             'xf' => 'required'
				         ]);
         
				         if($validator->fails())
				         {
				         	return redirect()->intended('products');
				         }
						else
						{
							$ss = "pending";
							
							switch($req['type'])
							{
								case "enable":
								  $ss = "enabled";
								break;
								
								case "disable":
								  $ss = "disabled";
								break;
							}
							
							$dd = [
							  'xf' => $req['xf'],
							  'status' => $ss
							];
							
						   $this->helpers->updateProductStatus($dd);
   	 					   $ss = "update-product-status";
   	 					   session()->flash($ss,"ok");
   	 			           return redirect()->intended("products");
					    }
	 				}
	 				else
	 				{
	 					session()->flash("permissions-status-error","ok");
	 					return redirect()->intended('/');
	 				}				
	 			}
	 			else
	 			{
	 				Auth::logout();
	 				$u = url('/');
	 				return redirect()->intended($u);
	 			}
	 		}
	 		else
	 		{
	 			$v = "login";
	 		}
	 		return view($v,compact($cpt));
		
	     }
	
	
	/**
	 * Show list of categories on the platform.
	 *
	 * @return Response
	 */
	public function getCategories(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "categories";
				$req = $request->all();
                $categories = $this->helpers->getCategories();
				#dd($categories);
                array_push($cpt,'categories');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Category view.
	 *
	 * @return Response
	 */
	public function getAddCategory(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-category";
					$categories = $this->helpers->getCategories();
					array_push($cpt,'categories');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add category.
	 *
	 * @return Response
	 */
	public function postAddCategory(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'name' => 'required',
		                    'meta_title' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					if(isset($req['image']))
					{
					$img = $request->file("image");
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  #break;
					  }
					  else
					  {
						$req['image'] = $imgg['public_id'];
					    $req['delete_token'] = $imgg['delete_token'];				  
					  }
					}
					else
					{
						$req['image'] = "";
						$req['delete_token'] = "";
						
					}
					$ret = $this->helpers->addCategory($req);
					$ss = "add-category-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("categories");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show the View Category view.
	 *
	 * @return Response
	 */
	public function getCategory(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "category";
					$c = $this->helpers->getCategory($req['xf']);
					#dd($c);
					if(count($c) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('categories');
					}
					else
					{
						$categories = $this->helpers->getCategories();
						array_push($cpt,'c');                                 
						array_push($cpt,'categories');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('categories');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 *Handle update category status
	 *
	 * @return Response
	 */
	public function getEnableDisableCategory(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
					$validator = Validator::make($req,[
		                    'xf' => 'required',
                             'type' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$t = $req['type']; $s = "pending";
					if($t == "enable") $s = "enabled";
					else if($t == "disable") $s = "disabled";
					
					$ret = $this->helpers->updateCategory(['xf' => $req['xf'],'status' => $s]);
					$ss = "update-category-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
					$uu = "categories";
			        return redirect()->intended($uu);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update category.
	 *
	 * @return Response
	 */
	public function postCategory(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
                             'name' => 'required',
                             'meta_title' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					if(isset($req['image']))
					{
					  $img = $request->file("image");
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  #break;
					  }
					  else
					  {
						$req['image'] = $imgg['public_id'];
					    $req['delete_token'] = $imgg['delete_token'];				  
					  }
					}
					$ret = $this->helpers->updateCategory($req);
					$ss = "update-category-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
					$uu = "categories";
			        return redirect()->intended($uu);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove category.
	 *
	 * @return Response
	 */
	public function getRemoveCategory(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeCategory($req['xf']);
					  $ss = "remove-category-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("categories");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of manufacturers on the platform.
	 *
	 * @return Response
	 */
	public function getManufacturers(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "manufacturers";
				$req = $request->all();
                $manufacturers = $this->helpers->getManufacturers();
				#dd($tickets);
                array_push($cpt,'manufacturers');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Manufacturer view.
	 *
	 * @return Response
	 */
	public function getAddManufacturer(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-manufacturer";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add manufacturer.
	 *
	 * @return Response
	 */
	public function postAddManufacturer(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'name' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					if(isset($req['image']))
					{
					$img = $request->file("image");
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  #break;
					  }
					  else
					  {
						$req['image'] = $imgg['public_id'];
					    $req['delete_token'] = $imgg['delete_token'];				  
					  }
					}
					else
					{
						$req['image'] = "";
						$req['delete_token'] = "";
						
					}
					$ret = $this->helpers->addManufacturer($req);
					$ss = "add-manufacturer-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("manufacturers");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show the View Manufacturer view.
	 *
	 * @return Response
	 */
	public function getManufacturer(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "manufacturer";
					$m = $this->helpers->getManufacturer($req['xf']);
					#dd($t);
					if(count($m) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('manufacturers');
					}
					else
					{
						array_push($cpt,'m');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('manufacturers');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	
	/**
	 * Handle update manufacturer.
	 *
	 * @return Response
	 */
	public function postManufacturer(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
                             'name' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					if(isset($req['image']))
					{
					$img = $request->file("image");
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  #break;
					  }
					  else
					  {
						$req['image'] = $imgg['public_id'];
					    $req['delete_token'] = $imgg['delete_token'];				  
					  }
					}
					$ret = $this->helpers->updateManufacturer($req);
					$ss = "update-manufacturer-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
					$uu = "manufacturers";
			        return redirect()->intended($uu);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove manufacturer.
	 *
	 * @return Response
	 */
	public function getRemoveManufacturer(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeManufacturer($req['xf']);
					  $ss = "remove-manufacturer-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("manufacturers");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }

	/**
	 * Show list of information on the platform.
	 *
	 * @return Response
	 */
	public function getInformation(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$v = "information";
				$req = $request->all();
                $information = $this->helpers->getInformation();
				$xx = $this->helpers->information_types;
				#dd($tickets);
                array_push($cpt,'information');
                array_push($cpt,'xx');
                }
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Information view.
	 *
	 * @return Response
	 */
	public function getAddInformation(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-information";
					$xx = $this->helpers->information_types;
					array_push($cpt,'xx');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add information.
	 *
	 * @return Response
	 */
	public function postAddInformation(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'title' => 'required',
		                    'type' => 'required',
		                    'content' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->addInformation($req);
					$ss = "add-information-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("information");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show the View Information view.
	 *
	 * @return Response
	 */
	public function getEditInformation(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "information-single";
					$i = $this->helpers->getInformationSingle($req['xf']);
					#dd($t);
					if(count($i) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('information');
					}
					else
					{
						$xx = $this->helpers->information_types;
					    array_push($cpt,'xx');
						array_push($cpt,'i');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('information');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	
	/**
	 * Handle update information.
	 *
	 * @return Response
	 */
	public function postEditInformation(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_tickets','edit_tickets']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required',
                             'title' => 'required',
                             'type' => 'required',
                             'content' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateInformation($req);
					$ss = "update-information-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
					$uu = "information";
			        return redirect()->intended($uu);
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove information.
	 *
	 * @return Response
	 */
	public function getRemoveInformation(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_plugins','edit_plugins']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeInformation($req['xf']);
					  $ss = "remove-information-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("information");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of banners.
	 *
	 * @return Response
	 */
	public function getBanners(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "banners";
				 $banners = $this->helpers->getBanners();
				 #dd($banners);
				 array_push($cpt,'banners');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Banner view.
	 *
	 * @return Response
	 */
	public function getAddBanner(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-banner";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add banner.
	 *
	 * @return Response
	 */
	public function postAddBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'ab-images' => 'required',
                             'type' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ird = [];
                    $networkError = false;
				
                    for($i = 0; $i < count($req['ab-images']); $i++)
                    {
            		  $img = $req['ab-images'][$i];
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  break;
					  }
					  else
					  {
						 $req['cover'] = "no";
					     $req['ird'] = $imgg['public_id'];
					     $req['delete_token'] = $imgg['delete_token'];
					     $req['deleted'] = "no";
					  }
             	        								
					}
					
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$req['status'] = "enabled";
					    $req['added_by'] = $user->id;
					   
			            $ret = $this->helpers->createBanner($req);
			            $ss = "add-banner-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("banners");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle update banner.
	 *
	 * @return Response
	 */
	public function getUpdateBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
                             'type' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateBanner($req);
					$ss = "update-banner-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("banners");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove banner.
	 *
	 * @return Response
	 */
	public function getRemoveBanner(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_banners','edit_banners']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeBanner($req['xf']);
					  $ss = "remove-banner-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("banners");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of FAQs.
	 *
	 * @return Response
	 */
	public function getApartmentTips(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_apartments','edit_apartments']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "apartment-tips";
				 $tips = $this->helpers->getApartmentTips();
				 #dd($tips);
				 array_push($cpt,'tips');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add FAQ view.
	 *
	 * @return Response
	 */
	public function getAddApartmentTip(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-apartment-tip";
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add FAQ.
	 *
	 * @return Response
	 */
	public function postAddApartmentTip(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'message' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$networkError = false;
				
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$ret = $this->helpers->createApartmentTip($req);
			            $ss = "add-apartment-tip-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("apartment-tips");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle remove banner.
	 *
	 * @return Response
	 */
	public function getRemoveApartmentTip(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeApartmentTip($req['xf']);
					  $ss = "remove-apartment-tip-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("apartment-tips");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of FAQs.
	 *
	 * @return Response
	 */
	public function getFAQs(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "faqs";
				 $faqs = $this->helpers->getFAQs();
				 #dd($banners);
				 array_push($cpt,'faqs');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add FAQ view.
	 *
	 * @return Response
	 */
	public function getAddFAQ(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-faq";
					$tags = $this->helpers->getFAQTags();
					array_push($cpt,'tags');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add FAQ.
	 *
	 * @return Response
	 */
	public function postAddFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'tag' => 'required',
                             'question' => 'required',
							 'answer' => "required"
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$networkError = false;
				
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$ret = $this->helpers->createFAQ($req);
			            $ss = "add-faq-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("faqs");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle update FAQ.
	 *
	 * @return Response
	 */
	public function getUpdateFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
                             'tag' => 'required',
                             'question' => 'required',
							 'answer' => "required"
							 
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateFAQ($req);
					$ss = "update-faq-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended("faqs");
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove FAQ.
	 *
	 * @return Response
	 */
	public function getRemoveFAQ(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQ($req['xf']);
					  $ss = "remove-faq-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faqs");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show list of FAQ tags.
	 *
	 * @return Response
	 */
	public function getFAQTags(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "faq-tags";
				 $tags = $this->helpers->getFAQTags();
				 #dd($banners);
				 array_push($cpt,'tags');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add FAQ view.
	 *
	 * @return Response
	 */
	public function getAddFAQTag(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-faq-tag";
					
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add FAQ.
	 *
	 * @return Response
	 */
	public function postAddFAQTag(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'tag' => 'required',
                             'name' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$networkError = false;
				
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$ret = $this->helpers->createFAQTag($req);
			            $ss = "add-faq-tag-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("faq-tags");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove FAQ tag.
	 *
	 * @return Response
	 */
	public function getRemoveFAQTag(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    #dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQTag($req['xf']);
					  $ss = "remove-faq-tag-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faq-tags");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show list of blog posts.
	 *
	 * @return Response
	 */
	public function getPosts(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "posts";
				 $posts = $this->helpers->getPosts();
				 #dd($posts);
				 array_push($cpt,'posts');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Post view.
	 *
	 * @return Response
	 */
	public function getAddPost(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-post";
					
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add post.
	 *
	 * @return Response
	 */
	public function postAddPost(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();

				if($hasPermission)
				{
				
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'title' => 'required',
                             'url' => 'required|unique:posts',
							 'ap-images' => 'required',
                             'content' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ird = [];
                    $networkError = false;
				
                    for($i = 0; $i < count($req['ap-images']); $i++)
                    {
            		  $img = $req['ap-images'][$i];
					  $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					  if(isset($imgg['status']) && $imgg['status'] == "error")
					  {
						  $networkError = true;
						  break;
					  }
					  else
					  {
						 $req['ird'] = $imgg['public_id'];
					  }
             	        								
					}
					
					if($networkError)
					{
						session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					}
					else
					{
						$req['status'] = "enabled";
					    $req['author'] = $user->id;
					   
			            $ret = $this->helpers->createPost($req);
			            $ss = "add-post-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->intended("posts");
					}
					
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Show the Update Post view.
	 *
	 * @return Response
	 */
	public function getUpdatePost(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "post";
					$p = $this->helpers->getPost($req['xf']);
				    #dd($p);
					if(count($p) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('posts');
					}
					else
					{
						array_push($cpt,'p');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('posts');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update post.
	 *
	 * @return Response
	 */
	public function postUpdatePost(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				$req = $request->all();
				#dd($req);
				
				$validator = Validator::make($req,[
		                     'xf' => 'required',
		                     'title' => 'required',
                             'url' => 'required',
							 'ap-images' => 'required',
                             'content' => 'required',
                             'status' => 'required'
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ird = [];
                    $networkError = false;
				    
					
                      for($i = 0; $i < count($req['ap-images']); $i++)
                      {
						  $img = $req['ap-images'][$i];
						  if($img != null)
					      {
            		        
					        $imgg = $this->helpers->uploadCloudImage($img->getRealPath());
						
					        if(isset($imgg['status']) && $imgg['status'] == "error")
					        {
						      $networkError = true;
						      break;
					        }
					        else
					        {
						      $req['ird'] = $imgg['public_id'];
					        }    								
					     }
					  }
					  if($networkError)
					  {
					    session()->flash("network-status-error","ok");
			            return redirect()->back()->withInput();
					  }
					  else
					  {
					    $req['author'] = $user->id;
					   
			            $ret = $this->helpers->updatePost($req);
			            $ss = "update-post-status";
					    if($ret == "error") $ss .= "-error";
					    session()->flash($ss,"ok");
			            return redirect()->back();
					  }
				    
				  }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	/**
	 * Handle remove post.
	 *
	 * @return Response
	 */
	public function getRemovePost(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_posts','edit_posts']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQTag($req['xf']);
					  $ss = "remove-faq-tag-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faq-tags");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Handle Respond to reservation request.
	 *
	 * @return Response
	 */
	public function getRespondToReservation(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
							'axf' => 'required',
							'gxf' => 'required|numeric'
		        ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->intended('/');
                }
				else
				{
					$dt = [
			         'id' => $req['xf'],
			         'apartment_id' => $req['axf'],
			         'user_id' => $req['gxf']
			        ];
			 
			       if($this->helpers->hasReservation($dt))
			       {
				     $dt['type'] = $req['type'];
				     $dt['auth'] = $user->id;
				
			         $this->helpers->respondToReservation($dt);
			         session()->flash("respond-to-reservation-status","ok");
                     return redirect()->intended('/');
			       }
			       else
			       {
			   	     session()->flash("duplicate-reservation-status-error","ok");
			         return redirect()->intended('/');
			       }
				 }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Show list of orders.
	 *
	 * @return Response
	 */
	public function getOrders(Request $request)
    {
		$user = null;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				 $v = "orders";
				 $orders = $this->helpers->getOrders();
				# dd($orders);
				 array_push($cpt,'orders');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}				
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Show the Add Order view.
	 *
	 * @return Response
	 */
	public function getAddOrder(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
					$v = "add-order";
					$customers = $this->helpers->getUsers();
					$products = $this->helpers->getProducts();
					$countries = $this->helpers->countries;
					$statuses = $this->helpers->statuses;
					array_push($cpt,'customers');
					array_push($cpt,'products');
					array_push($cpt,'countries');
					array_push($cpt,'statuses');
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Handle add order.
	 *
	 * @return Response
	 */
	public function postAddOrder(Request $request)
    {
		$user = null;
		$ret = ['status' => "error", 'message' => "nothing happened"];
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();

				if($hasPermission)
				{			
				$validator = Validator::make($req,[
		                     'amount' => 'required|numeric',
		                     'customer' => 'required|numeric',
                             'payment_fname' => 'required',
                             'payment_lname' => 'required',
                             'payment_address_1' => 'required',
                             'payment_city' => 'required',
                             'payment_lname' => 'required',
                             'payment_region' => 'required',
							 'payment_country' => 'required',
                             'shipping_fname' => 'required',
                             'shipping_lname' => 'required',
                             'shipping_address_1' => 'required',
                             'shipping_city' => 'required',
                             'shipping_region' => 'required',
                             'shipping_country' => 'required',
                             'payment_type' => 'required',
                             'shipping_type' => 'required',
                             'status' => 'required',
                             'products' => 'required',
		                   ]);
						
				   if($validator->fails())
                   {
                     $ret['message'] = "validation";
                   }
				   else
				   {   
			           $ret = $this->helpers->addOrder($req);
			           $ret = ['status' => "ok"];
				   }
				}
				else
				{
					$ret['message'] = "Technical error";
				}
			}
			else
			{
				$ret['message'] = "Technical error";
			}
		}
		else
		{
			$ret['message'] = "Technical error";
		}
		
		return json_encode($ret);
    }
	
	
	/**
	 * Show the Update Order view.
	 *
	 * @return Response
	 */
	public function getUpdateOrder(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "order";
					$o = $this->helpers->getOrder($req['xf']);
				    #dd($o);
					if(count($o) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('o');
					}
					else
					{
						if(isset($req['type']) && $req['type'] == "edit") $v = "edit-order";
						array_push($cpt,'o');                                 
						$customers = $this->helpers->getUsers();
					    $products = $this->helpers->getProducts();
					    $countries = $this->helpers->countries;
					    $statuses = $this->helpers->statuses;
					    array_push($cpt,'customers');
				        array_push($cpt,'products');
					    array_push($cpt,'countries');                                 
					    array_push($cpt,'statuses');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('plans');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle update order.
	 *
	 * @return Response
	 */
	public function postUpdateOrder(Request $request)
    {
		$user = null;
		$ret = ['status' => "error", 'message' => "nothing happened"];
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();

				if($hasPermission)
				{			
				$validator = Validator::make($req,[
		                     'amount' => 'required|numeric',
		                     'customer' => 'required|numeric',
                             'payment_fname' => 'required',
                             'payment_lname' => 'required',
                             'payment_address_1' => 'required',
                             'payment_city' => 'required',
                             'payment_lname' => 'required',
                             'payment_region' => 'required',
							 'payment_country' => 'required',
                             'shipping_fname' => 'required',
                             'shipping_lname' => 'required',
                             'shipping_address_1' => 'required',
                             'shipping_city' => 'required',
                             'shipping_region' => 'required',
                             'shipping_country' => 'required',
                             'payment_type' => 'required',
                             'shipping_type' => 'required',
                             'status' => 'required',
                             'products' => 'required',
		                   ]);
						
				   if($validator->fails())
                   {
                     $ret['message'] = "validation";
                   }
				   else
				   {   
			           $ret = $this->helpers->updateOrder($req);
			           $ret = ['status' => "ok"];
				   }
				}
				else
				{
					$ret['message'] = "Technical error";
				}
			}
			else
			{
				$ret['message'] = "Technical error";
			}
		}
		else
		{
			$ret['message'] = "Technical error";
		}
		
		return json_encode($ret);
    }
	
	
	/**
	 * Handle remove order.
	 *
	 * @return Response
	 */
	public function getRemoveOrder(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$req = $request->all();
			   	    dd($req);
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				
				if($hasPermission)
				{
				
				    $validator = Validator::make($req,[
		                    'xf' => 'required|numeric'
		                   ]);
						
				    if($validator->fails())
                    {
                      session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                    }
				    else
				    {   
					  $ret = $this->helpers->removeFAQTag($req['xf']);
					  $ss = "remove-faq-tag-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("faq-tags");
				    }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	/**
	 * Redirect
	 *
	 * @return Response
	 */
	public function getAddOrderHistory(Request $request)
    {
		return redirect()->intended('orders');
    }
	
	/**
	 * Handle add order.
	 *
	 * @return Response
	 */
	public function postAddOrderHistory(Request $request)
    {
		$user = null;
		
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();

				if($hasPermission)
				{			
				$validator = Validator::make($req,[
		                     'xf' => 'required|numeric',
		                     'status' => 'required|not_in:none',
                             'nc' => 'required|not_in:none'
		                   ]);
						
				   if($validator->fails())
                   {
                     session()->flash("validation-status-error","ok");
			          return redirect()->back()->withInput();
                   }
				   else
				   {   
			           $ret = $this->helpers->createOrderHistory($req);
			           $ss = "add-order-history-status";
					  if($ret == "error") $ss .= "-error";
					  session()->flash($ss,"ok");
			          return redirect()->intended("order?xf=".$req['xf']);
				   }
				}
				else
				{
					session()->flash("permissions-status-error","ok");
			        return redirect()->intended("/");
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended("/");
		}
		
    }
	
	/**
	 * Show the Invoice view.
	 *
	 * @return Response
	 */
	public function getInvoice(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "invoice";
					$o = $this->helpers->getOrder($req['xf']);
				    #dd($o);
					if(count($o) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('orders');
					}
					else
					{
						if(isset($req['type']) && $req['type'] == "edit") $v = "edit-order";
						array_push($cpt,'o');                                 
						$countries = $this->helpers->countries;
					    $statuses = $this->helpers->statuses;
						$products = $this->helpers->getProducts();
					    array_push($cpt,'products');                                 
					    array_push($cpt,'countries');                                 
					    array_push($cpt,'statuses');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('orders');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	/**
	 * Show the Shipping List view.
	 *
	 * @return Response
	 */
	public function getShippingList(Request $request)
    {
		$user = null;
		$nope = false;
		$v = "";
		
		$signals = $this->helpers->signals;
		$plugins = $this->helpers->getPlugins();
		$permissions = $this->helpers->permissions;
		#$this->helpers->populateTips();
        $cpt = ['user','signals','plugins'];
				
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
                
				if(isset($req['xf']))
				{
					$v = "shipping-list";
					$o = $this->helpers->getOrder($req['xf']);
				    #dd($o);
					if(count($o) < 1)
					{
						session()->flash("validation-status-error","ok");
						return redirect()->intended('orders');
					}
					else
					{
						if(isset($req['type']) && $req['type'] == "edit") $v = "edit-order";
						array_push($cpt,'o');                                 
						$countries = $this->helpers->countries;
					    $statuses = $this->helpers->statuses;
						$products = $this->helpers->getProducts();
					    array_push($cpt,'products');      
					    array_push($cpt,'countries');                                 
					    array_push($cpt,'statuses');                                 
					}
					
				}
				else
				{
					session()->flash("validation-status-error","ok");
					return redirect()->intended('orders');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
								
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			$v = "login";
		}
		return view($v,compact($cpt));
    }
	
	
	/**
	 * Handle Enable/Disable plan.
	 *
	 * @return Response
	 */
	public function getEnableDisablePlan(Request $request)
    {
		$user = null;
		if(Auth::check())
		{
			$user = Auth::user();
			
			if($this->helpers->isAdmin($user))
			{
				$hasPermission = $this->helpers->hasPermission($user->id,['view_users','edit_users']);
				#dd($hasPermission);
				$req = $request->all();
				
				if($hasPermission)
				{
				$validator = Validator::make($req,[
		                    'xf' => 'required|numeric',
		                    'type' => 'required',
		                   ]);
						
				if($validator->fails())
                {
                  session()->flash("validation-status-error","ok");
			      return redirect()->back()->withInput();
                }
				else
				{
					$ret = $this->helpers->updateEDP($req);
					$ss = "update-plan-status";
					if($ret == "error") $ss .= "-error";
					session()->flash($ss,"ok");
			        return redirect()->intended('plans');
				}
				}
				else
				{
					session()->flash("permissions-status-error","ok");
					return redirect()->intended('/');
				}
			}
			else
			{
				Auth::logout();
				$u = url('/');
				return redirect()->intended($u);
			}
		}
		else
		{
			return redirect()->intended('/');
		}
    }
	
	
	
	
	
	
	
	
	
	
/**
	 * Switch user mode (host/guest).
	 *
	 * @return Response
	 */
	public function getTestBomb(Request $request)
    {
		$user = null;
		$messages = [];
		$ret = ['status' => "error", 'message' => "nothing happened"];
		
		if(Auth::check())
		{
			$user = Auth::user();
			$messages = $this->helpers->getMessages(['user_id' => $user->id]);
		}
		else
		{
			$ret['message'] = "auth";
		}
		
		$req = $request->all();
		
		$validator = Validator::make($req, [
                             'type' => 'required',
                             'method' => 'required',
                             'url' => 'required'
         ]);
         
         if($validator->fails())
         {
             $ret['message'] = "validation";
         }
		 else
		 {
       $rr = [
          'data' => [],
          'headers' => [],
          'url' => $req['url'],
          'method' => $req['method']
         ];
      
      $dt = [];
      
		   switch($req['type'])
		   {
		     case "bvn":
		       /**
			   $rr['data'] = [
		         'bvn' => $req['bvn'],
		         'account_number' => $req['account_number'],
		        'bank_code' => $req['bank_code'],
		         ];
		       **/  
			   //localhost:8000/tb?url=https://api.paystack.co/bank/resolve_bvn/:22181211888&method=get&type=bvn
		         $rr['headers'] = [
		           'Authorization' => "Bearer ".env("PAYSTACK_SECRET_KEY")
		           ];
		     break;
		   }
		   
			$ret = $this->helpers->bomb($rr);
			 
		 }
		 
		 dd($ret);
    }
	
	
	

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function getZoho()
    {
        $ret = "97916613";
    	return $ret;
    }
	
	

	
}
