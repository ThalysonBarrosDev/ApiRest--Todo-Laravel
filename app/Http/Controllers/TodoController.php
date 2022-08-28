<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;

class TodoController extends Controller {

    public function create(Request $request) {

        try {

            $rules = [
                'title' => 'required|min:3'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { 

                return response()->json(['error' => true, 'message' => $validator->messages()], 500); 

            }

            $title = $request->input('title');

            $todo = new Todo();
            $todo->title = $title;
            $todo->save();

            return response()->json(['success' => true, 'message' => 'Tarefa criada com sucesso.'], 200); 

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function readAll() {

        try {

            $todos = Todo::all();

            return response()->json(['success' => true, 'list' => $todos], 200);

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function read($id) {

        try {

            $todo = Todo::find($id);

            if ($todo) {

                return response()->json(['success' => true, 'list' => $todo], 200);

            } else {

                return response()->json(['error' => true, 'message' => 'Tarefa '.$id.' não encontrada, verifique.'], 500); 

            }

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function update(Request $request, $id) {

        try {
            
            $rules = [
                'title' => 'min:3',
                'done' => 'boolean'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) { 

                return response()->json(['error' => true, 'message' => $validator->messages()], 500); 

            }

            $title = $request->input('title');
            $done = $request->input('done');



            $todo = Todo::find($id);

            if ($todo) {

                if ($title) {

                    $todo->title = $title;

                }

                if ($done !== NULL) {

                    $todo->done = $done;

                }

                $todo->save();

                return response()->json(['success' => true, 'list' => $todo], 200);

            } else {

                return response()->json(['error' => true, 'message' => 'Tarefa '.$id.' não encontrada, verifique.'], 500); 

            }

        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

    public function delete($id) {

        try {

            $todo = Todo::find($id);

            if ($todo) {

                $todo->delete();

                return response()->json(['success' => true, 'message' => 'Tarefa '.$id.' deletada com sucesso.'], 200); 

            } else {

                return response()->json(['error' => true, 'message' => 'Tarefa '.$id.' não encontrada, verifique.'], 500); 

            }


        } catch (Exception $e) {

            return response()->json(['error' => true, 'message' => $e->getMessage()], $e->getCode());

        }

    }

}