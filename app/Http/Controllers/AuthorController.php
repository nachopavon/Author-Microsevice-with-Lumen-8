<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthorController extends Controller
{
    use ApiResponse;

    /**
     * list of authors
     * @return JsonResponse
     */
    public function index()
    {
        $authors = Author::all();
        return $this->successResponse($authors, 'List of authors');
    }

    /**
     *  create new author
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'gender' => 'required|max:255|in:male,female',
            'country' => 'required|max:255|',
        ];

        $this->validate($request, $rules);


        $author = Author::create($request->all());
        return $this->successResponse($author, 'Author created', 201);
    }

    /**
     *  show author profile
     * @param $author
     * @return JsonResponse
     */
    public function show($author)
    {
        $author = Author::findOrFail($author);
        return $this->successResponse($author, 'Showing author profile');
    }

    /**
     * update author info
     * @param Request $request
     * @param $author
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'name' => 'max:255',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        $this->validate($request, $rules);

        $author = Author::findOrFail($author);
        $author->fill($request->all());

        if ($author->isClean())
            return $this->errorResponse('At least one value must change', 422);

        $author->save();

        return $this->successResponse($author, 'Updated author profile');
    }

    /**
     * remove author
     * @param $author
     * @return JsonResponse
     */
    public function destroy($author)
    {
        $authorUser = Author::findOrFail($author);
        $authorUser->delete();
        return $this->successResponse(['id' => $author], 'Author deleted');
    }
}
