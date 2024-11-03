<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		return redirect()->route('admin.dashboard');
	}

	public function dashboard()
	{
		$totalVisitor = DB::table('visitor')
			->select(DB::raw("count(*) as total"))
			->get();

		$totalPost = DB::table('posts')
			->select(DB::raw("count(*) as total"))
			->get();

		$totalFeedback = DB::table('feedbacks')
			->select(DB::raw("count(*) as total"))
			->get();

		// Start get visitor
		$subqueryGuest = DB::table('visitor')
			->select(DB::raw('LEFT(MONTHNAME(date_visitor), 3) AS month, COUNT(*) AS jumlah'))
			->whereYear('date_visitor', '=', date('Y'))
			->groupBy(DB::raw('LEFT(MONTHNAME(date_visitor), 3)'));

		$resultGuest = DB::table(DB::raw("({$subqueryGuest->toSql()}) as sub"))
			->mergeBindings($subqueryGuest) 
			->select('month', 'jumlah')
			->get();
		// End get visitor

		// Start get counter post
		$subqueryPost = DB::table('posts')
			->select(DB::raw('LEFT(MONTHNAME(created_at), 3) AS month, COUNT(*) AS jumlah'))
			->whereYear('created_at', '=', date('Y'))
			->groupBy(DB::raw('LEFT(MONTHNAME(created_at), 3)'));

		$resultPost = DB::table(DB::raw("({$subqueryPost->toSql()}) as sub"))
			->mergeBindings($subqueryPost) 
			->select('month', 'jumlah')
			->get();
		// End get counter post

		// Start get ration of feedback
		$getRatioNotSpam = DB::table('feedbacks')
			->join('feedback_category', 'feedbacks.feedback_category', '=', 'feedback_category.category_id')
			->select(DB::raw("
				feedback_category.category_desc,
				COUNT(*) as jumlah
			"))
			->where('spam_status', '=', null)
			->groupBy(DB::raw("category_desc"));

		$getRatioSpam = DB::table('feedbacks')
			->select(DB::raw("
				'Spam' as category_desc,
				COUNT(*) as jumlah
			"))
			->where('spam_status', '=', 1)
			->groupBy(DB::raw("category_desc"));
		
		$ratioFeedback = $getRatioNotSpam->unionAll($getRatioSpam)->get();
		// End get ratio of feedback

		// Get consultation data
		$getConsultation = DB::table('feedbacks')
			->select(DB::raw("
				CASE
					WHEN reply_status = 1 THEN 'Dibalas'
					ELSE 'Belum dibalas'
				END as reply_status,
				COUNT(*) as jumlah
			"))
			->where('feedback_category', '=', 1)
			->where('spam_status', '=', null)
			->groupBy(DB::raw("
				CASE
					WHEN reply_status = 1 THEN 'Dibalas'
					ELSE 'Belum dibalas'
				END
			"))
			->get();

			// dd($getConsultation);
		
		// Get complaint data
		$getComplaint = DB::table('feedbacks')
			->select(DB::raw("
				CASE
					WHEN reply_status = 1 THEN 'Dibalas'
					ELSE 'Belum dibalas'
				END as reply_status,
				COUNT(*) as jumlah
			"))
			->where('feedback_category', '=', 2)
			->where('spam_status', '=', null)
			->groupBy(DB::raw("
				CASE
					WHEN reply_status = 1 THEN 'Dibalas'
					ELSE 'Belum dibalas'
				END
			"))
			->get();

		return view('admin.dashboard.dashboard', ['totalVisitor' => $totalVisitor, 'totalPost' => $totalPost, 'totalFeedback' => $totalFeedback, 'countGuest' => $resultGuest, 'countPost' => $resultPost, 'consultation' => $getConsultation, 'complaint' => $getComplaint, 'ratioFeedback' => $ratioFeedback]);
	}
}
