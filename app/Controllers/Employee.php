<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use App\Models\EmployeeImageModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\EmployeePropertyModel;

class Employee extends BaseController
{
    public function index()
    {
        $empModel = new EmployeeModel();
        $perPage = 5;
    
        $query = $empModel->orderBy('id', 'DESC');
        $data['employee'] = $query->paginate($perPage);
        $data['pager']     = $empModel->pager;
    
        return view('employee/listing', $data);
    }

    public function create()
    {
        return view('employee/create');
    }

        // This method handles the AJAX request for a single record
        public function getRecord($id = null)
        {
            if ($this->request->isAJAX()) {
                $model = new EmployeeModel();
                $record = $model->find($id);
    
                // You can also return the data in JSON format for flexibility
                return $this->response->setJSON($record);
            }
        }
    

    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            'email'    => 'required|valid_email|is_unique[employees.email]',
            'position' => 'required|min_length[2]|max_length[100]',
            //'images.*' => 'uploaded[images]|is_image[images]'
        ];
    
        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }
    
        $model = new EmployeeModel();
        $propertyModel = new EmployeePropertyModel();

        $employeeId = $model->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'position' => $this->request->getPost('position'),
        ]);

        // Save properties
        $names = $this->request->getPost('property_name');
        $values = $this->request->getPost('property_value');

        if ($names && $values) {
            foreach ($names as $index => $name) {
                if ($name != '') { // ignore empty
                    $propertyModel->insert([
                        'employee_id' => $employeeId,
                        'property_name' => $name,
                        'property_value' => $values[$index],
                    ]);
                }
            }
        }

            // Save multiple images
    $imageModel = new EmployeeImageModel();
    $files = $this->request->getFiles();

    if ($files && isset($files['images'])) {
        foreach ($files['images'] as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/employees/', $newName);

                $imageModel->insert([
                    'employee_id' => $employeeId,
                    'image'       => $newName
                ]);
            }
        }
    }

        session()->setFlashdata('success', 'Employee added successfully!');

        return $this->response->setJSON([
            'status'  => 'success',
            'redirect' => base_url('/employee')
        ]);


       // return redirect()->to('/employee');
    }

    public function edit($id)
    {
        $model = new EmployeeModel();
        $imageModel    = new EmployeeImageModel();
        $propertyModel = new EmployeePropertyModel();

        $data['employee'] = $model->find($id);
        $data['images'] = $imageModel->where('employee_id', $id)->findAll();
        $data['properties'] = $propertyModel->where('employee_id', $id)->findAll();

        return view('employee/edit', $data);
    }

    public function update($id)
    {

        $validation = \Config\Services::validation();

        $rules = [
            'name'     => 'required|min_length[3]|max_length[100]',
            //'email'    => "required|valid_email|is_unique[employees.email,id,{id}]",
            'email'    => "required|valid_email",
            'position' => 'required|min_length[2]|max_length[100]',
            //'images.*' => 'max_size[images,2048]'
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        $model = new \App\Models\EmployeeModel();
        $model->update($id, [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'position' => $this->request->getPost('position'),
        ]);

        $propertyModel = new \App\Models\EmployeePropertyModel();

        // Delete old properties
        $propertyModel->where('employee_id', $id)->delete();

        $names = $this->request->getPost('property_name');
        $values = $this->request->getPost('property_value');

        if ($names && $values) {
            foreach ($names as $index => $name) {
                if ($name != '') {
                    $propertyModel->insert([
                        'employee_id' => $id,
                        'property_name' => $name,
                        'property_value' => $values[$index],
                    ]);
                }
            }
        }

        $imageModel = new EmployeeImageModel();
        $files = $this->request->getFileMultiple('images');
        if ($files) {
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/employees/', $newName);
    
                    $imageModel->insert([
                        'employee_id' => $id,
                        'image'       => $newName
                    ]);
                }
            }
        }
        
        session()->setFlashdata('success', 'Employee updated successfully!');

        return $this->response->setJSON([
            'status'  => 'success',
            'redirect' => base_url('/employee')
        ]);

    }

    public function delete($id)
    {
        $model = new EmployeeModel();
        $model->delete($id);
        return redirect()->to('/employee');
    }

    public function deleteImage($id)
    {
        $imageModel = new EmployeeImageModel();
        $image = $imageModel->find($id);

        if($image){
            // Delete file from folder
            if(file_exists(FCPATH.'uploads/employees/'.$image['image'])){
                unlink(FCPATH.'uploads/employees/'.$image['image']);
            }

            // Delete record
            $imageModel->delete($id);
        }

        return $this->response->setJSON([
            'status' => 'success'
        ]);
    }

}
