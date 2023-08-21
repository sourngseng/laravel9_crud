<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyAjaxController extends Controller
{
    // set index page view
	public function index() {
		return view('companies.list');
	}

	// handle fetch all eamployees ajax request
	public function fetchAll() {
		$companies = Company::all();
		$output = '';
		if ($companies->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle dt-responsive nowrap">
            <thead>
              <tr>
                <th>ID</th>
                <th>Logo</th>
                <th>Company Name</th>
                <th>E-mail</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($companies as $row) {
				$output .= '<tr>
                <td>' . $row->id . '</td>
                <td><img src="storage/images/' . $row->logo . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $row->name . '</td>
                <td>' . $row->email . '</td>
                <td>' . $row->address . '</td>                <
                <td>
                  <a href="#" id="' . $row->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editCompanyModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $row->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
		}
	}

	// handle insert a new Company ajax request
	public function save_company(Request $request) {
		$file = $request->file('logo');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);

		$savData = [
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,

            'logo' => $fileName
        ];

		Company::create($savData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle edit an Company ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Company::find($id);
		return response()->json($emp);
	}

	// handle update an Company ajax request
	public function update(Request $request) {
		$fileName = '';
		$emp = Company::find($request->emp_id);
		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($emp->logo) {
				Storage::delete('public/images/' . $emp->logo);
			}
		} else {
			$fileName = $request->emp_avatar;
		}

		$empData = [
            'name' => $request->name,
            // 'last_name' => $request->lname,
            'email' => $request->email,
            'addrest' => $request->addrest,
            // 'post' => $request->post,
            'logo' => $fileName
        ];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

	// handle delete an Company ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$emp = Company::find($id);
		if (Storage::delete('public/images/' . $emp->avatar)) {
			Company::destroy($id);
		}
	}
}
