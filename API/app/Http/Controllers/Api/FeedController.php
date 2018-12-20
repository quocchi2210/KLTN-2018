<?php

namespace App\Http\Controllers\Api;

use App\Friends;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Feed;
use DB;
use App\User;

class FeedController extends Controller
{
    /**
     * @SWG\Get(
     *   path="/api/show",
     *   summary="Newfeeds",
     *     tags={"User Feed"},
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   ),
     * security={{"api_key": {}}}
     * )
     */
    public function show(Request $request)
    {
        $post = DB::table('feed')
            ->join('user_friend',function ($join){
                $join->on('user_friend.user_id','=','feed.user_post_id')
                     ->orOn('user_friend.friend_id','=','feed.user_post_id');
            })
            ->join('users','users.id','=','feed.user_post_id')
            ->whereRaw('users.disabled != ? AND users.locked != ?',[1,1])
            ->select('users.id','users.name','feed.title', 'feed.content','feed.updated_at AS Post date')
            ->where(function ($query) use ($request){
                $query->where([['user_friend.user_id',$request->authen_id],
                    ['user_friend.accepted',1],
                    ['user_friend.followed',1],
                    ['user_friend.blocked',0],
                ])
                ->orWhere([['user_friend.friend_id',$request->authen_id],
                    ['user_friend.accepted',1],
                    ['user_friend.followed',1],
                    ['user_friend.blocked',0],
                ]);
            })
            ->orWhere('feed.user_post_id',$request->authen_id)
            ->distinct()
            ->orderBy('feed.updated_at','desc')
            ->get();
        return $this->respondWithSuccess($post);
    }
    /**
     * @SWG\Post(
     *   path="/api/create",
     *   summary="Create Post",
     *     tags={"User Feed"},
     *   @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     description="Your title",
     *     type="string",
     *   ),
     *   @SWG\Parameter(
     *     name="content",
     *     in="query",
     *     description="Your content",
     *     type="string",
     *   ),
     * security={{"api_key":{}}},
     *   @SWG\Response(
     *     response=200,
     *     description="A list with products"
     *   ),
     *   @SWG\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function create(Request $request)
    {
        $rules = new Feed;
        $message =[
            'title.required'   => 'The title is required',
            'title.alpha'      => 'The title may only contain letters',
            'title.min'        => 'The title must be at least 8 character.',
            'title.max'        => 'The title may not be greater than 255 character.',
            'content.required' => 'The content is required',
            'content.max'      => 'The content may not be greater than 255 character.'
        ];
        $validator = Validator::make($request->all(),$rules->ruleCustom,$message);
        if ( $validator->fails() ) {
            return $this->errorWithValidation($validator);
        }
        $token = $request->headers->get('token');
        $data = User::where('id',(DB::table('token')->where('token', $token)->first()->user_token_id))->first()->id;
        if($data != 0){
            $post = new Feed;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->user_post_id = $data;
            $post->save();
            return $this->respondWithSuccess($post);
        }
    }
}
