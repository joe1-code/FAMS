<?php

namespace App\Repositories;

use App\Models\MonthlyPayment;
use App\Models\NotificationDocument;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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
            'document' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png,gif|max:2048',
            // 'message' => 'please choose a document'
        ]);

        if ($request->hasFile('document')) {
            
            $file = $request->file('document');
            $filename = time() .'_'. $file->getClientOriginalName();

            $path = $file->storeAs('documents', $filename, 'public');
            // $storagePath = public_path('assets/documents');
            // $file->move($storagePath, $file);
            // $path = ('assets/documents/' . $filename);
            // dd($path);

            DB::transaction(function() use($filename, $path, $file, $request){
                NotificationDocument::create([
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'user_id' => (int)$request->id,
                ]);
            });
            
        }

        $docId = NotificationDocument::select('id')->where('filename', $filename)->first()->id;

        return $docId;
    }

    public function monthlyViewDoc($data){
        // dd($data->all());
        $document = MonthlyPayment::where('monthly_payments.user_id', (int)$data->id)
                    ->join('notification_documents as nd','nd.id', '=', 'monthly_payments.document_id')
                    ->whereMonth('pay_date', $data->contr_month)
                    ->whereYear('pay_date', $data->contr_year)
                    ->get();

        if ($document->isNotEmpty()) {
            return response()->json(['status' => 'success', 'document' => $document[0]['filename']]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No document was found for specified month and a year']);
        }
   
    }
}
