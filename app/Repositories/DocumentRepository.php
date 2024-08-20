<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use App\Models\NotificationDocument;
use App\Repositories\BaseRepository;

class DocumentRepository implements BaseRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(MonthlyPayment $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function storeMonthlyPaymentsDocs($request){

        $validation = $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048',
            // 'message' => 'please choose a document'
        ]);

        if ($request->hasFile('document')) {
            
            $file = $request->file('document');
            $filename = time() .'_'. $file->getClientOriginalName();

            $path = $file->storeAs('documents', $filename, 'public'); /*storage/app/public/documents*/

            NotificationDocument::create([
                'filename' => $filename,
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'user_id' => (int)$request->id,
            ]);
        }

        $docId = NotificationDocument::select('id')->where('filename', $filename)->first()->id;

        return $docId;
    }
}
