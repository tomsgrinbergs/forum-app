<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CommentUpvote;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::query()
            ->with('user', 'category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('threads.index', [
            'threads' => $threads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('threads.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'max:255'],
            'content' => ['required'],
        ]);

        Auth::user()->threads()->create([
            'category_id' => $request->input('category'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('threads.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        $thread->load([
            'user',
            'comments' => function ($query) {
                $query->withCount('upvotes');
            },
            'comments.user',
        ]);

        $upvotedComments = CommentUpvote::query()
            ->where('user_id', Auth::id())
            ->whereIn('comment_id', $thread->comments->pluck('id'))
            ->pluck('comment_id');

        return view('threads.show', [
            'thread' => $thread,
            'upvotedComments' => $upvotedComments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
