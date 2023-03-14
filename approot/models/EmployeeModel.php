<?php

class EmployeeModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function addEmployee($data, $isAdmin = false)
    {
        $mode = 'New Addition';
        $status = 3;

        if ($isAdmin) {
            $status = 1;
        }

        $clientDetails = $this->qm->single('ri_clients_tbl', "*", ['cid' => $data['cid']]);

        $existingEmp = $this->qm->single('ri_employee_tbl', "*", ['cid' => $data['cid'], 'pid' => $data['pid'], 'emp_id' => $data['emp_id']]);

        if ($existingEmp) {
            return false;
        }

        if (isset($_FILES['card']) && !empty($_FILES['card'])) {
            $cardData =  $this->qm->upload('./external/uploads/', 'card');
        }

        if (!empty($_FILES['pimage']['name'])) {
            $pimageData =  $this->qm->upload('./external/uploads/', 'pimage', 'jpg|jpeg|png|jpg|gif|pdf');
        }

        $insertData = [
            'cid' => $data['cid'],
            'pid' => $data['pid'],
            'client_code' => ($clientDetails) ? $clientDetails->ccode : NULL,
            'client_name' => ($clientDetails) ? $clientDetails->cname : NULL,
            'up_time' => date('Y-m-d H:i:s'),
            'data_type' => 0,
            'sum_insured' => (isset($data['sum_insured']) && !empty($data['sum_insured'])) ? $data['sum_insured'] : 0,
            'card' => (isset($cardData) && !empty($cardData)) ? $cardData : NULL,
            'pimage' => (isset($pimageData) && !empty($pimageData)) ? $pimageData : NULL,
            'username' => (isset($data['username']) && !empty($data['username'])) ? $data['username'] : $clientDetails->ccode . '-' . $data['emp_id'],
            'password' => (isset($data['password']) && !empty($data['password'])) ? $data['password'] : $clientDetails->ccode . '-' . $data['emp_id'],
            'emp_id' => $data['emp_id'],
            'emp_name' => $data['name'],
            'name' => $data['name'],
            'email' => (isset($data['email']) && !empty($data['email'])) ? $data['email'] : NULL,
            'mobile' => (isset($data['mobile']) && !empty($data['mobile'])) ? $data['mobile'] : NULL,
            'relation' => 'Self',
            'gender' => $data['gender'],
            'wedd_date' => (isset($data['wedd_date']) && !empty($data['wedd_date'])) ? date('Y-m-d', strtotime($data['wedd_date'])) : NULL,
            'dob' => (isset($data['dob']) && !empty($data['dob'])) ? date('Y-m-d', strtotime($data['dob'])) : NULL,
            'age' => (isset($data['age']) && ($data['age'] != '')) ? $data['age'] : NULL,
            'doj' => (isset($data['doj']) && !empty($data['doj'])) ? date('Y-m-d', strtotime($data['doj'])) : NULL,
            'dol' => (isset($data['dol']) && !empty($data['dol'])) ? date('Y-m-d', strtotime($data['dol'])) : NULL,
            'mode' => $mode,
            'hr_approval_date' => NULL,
            'status' => $status,
            'created_on' => date('Y-m-d H:i:s'),
            'reson' => (isset($data['reson']) && !empty($data['reson'])) ? $data['reson'] : NULL,
            'covered_days' => $data['covered_days'],
            'annual_premium' => $data['annual_premium'],
            'premium' => $data['premium'],
        ];

        $lastId = $this->qm->insert('ri_employee_tbl', $insertData);

        return ($lastId) ? $lastId : false;
    }

    public function updateEmployee($data, $isAdmin = false)
    {
        $existingEmp = $this->qm->single('ri_employee_tbl', "*", ['eid' => $data['eid']]);

        if (empty($existingEmp)) {
            return false;
        }

        $mode = ($existingEmp->status != 3) ? 'Correction' : $existingEmp->mode;
        $status = 3;

        if ($existingEmp->status == 1 || $existingEmp->status == 0) {
            $this->addEmployeeVersion($existingEmp, 'emp');
        }

        if ($isAdmin) {
            $status = 1;
            $this->deleteEmployeeVersion($existingEmp->eid, 'emp');
        }

        if (isset($_FILES['card']) && !empty($_FILES['card'])) {
            $cardData =  $this->qm->upload('./external/uploads/', 'card');
        }

        if (!empty($_FILES['pimage']['name'])) {
            $pimageData =  $this->qm->upload('./external/uploads/', 'pimage', 'jpg|jpeg|png|jpg|gif|pdf');
        }

        $insertData = [
            'up_time' => date('Y-m-d H:i:s'),
            'sum_insured' => (isset($data['sum_insured']) && !empty($data['sum_insured'])) ? $data['sum_insured'] : $existingEmp->sum_insured,
            'card' => (isset($cardData) && !empty($cardData)) ? $cardData : $existingEmp->card,
            'pimage' => (isset($pimageData) && !empty($pimageData)) ? $pimageData : $existingEmp->pimage,
            'username' => (isset($data['username']) && !empty($data['username'])) ? $data['username'] : $existingEmp->username,
            'password' => (isset($data['password']) && !empty($data['password'])) ? $data['password'] : $existingEmp->password,
            'emp_id' => $data['emp_id'],
            'emp_name' => $data['name'],
            'name' => $data['name'],
            'email' => (isset($data['email']) && !empty($data['email'])) ? $data['email'] : $existingEmp->email,
            'mobile' => (isset($data['mobile']) && !empty($data['mobile'])) ? $data['mobile'] : $existingEmp->mobile,
            'relation' => 'Self',
            'gender' => $data['gender'],
            'wedd_date' => (isset($data['wedd_date']) && !empty($data['wedd_date'])) ? date('Y-m-d', strtotime($data['wedd_date'])) : $existingEmp->wedd_date,
            'dob' => (isset($data['dob']) && !empty($data['dob'])) ? date('Y-m-d', strtotime($data['dob'])) : $existingEmp->dob,
            'age' => (isset($data['age']) && ($data['age'] != '')) ? $data['age'] : $existingEmp->age,
            'doj' => (isset($data['doj']) && !empty($data['doj'])) ? date('Y-m-d', strtotime($data['doj'])) : $existingEmp->doj,
            'dol' => (isset($data['dol']) && !empty($data['dol'])) ? date('Y-m-d', strtotime($data['dol'])) : $existingEmp->dol,
            'mode' => $mode,
            'hr_approval_date' => NULL,
            'status' => $status,
            'reson' => (isset($data['reson']) && !empty($data['reson'])) ? $data['reson'] : $existingEmp->reson,
            'covered_days' => $data['covered_days'],
            'annual_premium' => $data['annual_premium'],
            'premium' => $data['premium'],
            'previous_premium' =>  $data['previous_premium'],
        ];

        $lastId = $this->qm->update('ri_employee_tbl', $insertData, ['eid' => $data['eid']]);

        return ($lastId) ? true : false;
    }

    public function addDependent($eid, $data, $isAdmin = false)
    {
        $mode = 'New Addition';
        $status = 3;

        if ($isAdmin) {
            $status = 1;
        }

        $existingEmp = $this->qm->single('ri_employee_tbl', "*", ['eid' => $eid]);

        if (!$existingEmp) {
            return false;
        }

        if (isset($_FILES['card']) && !empty($_FILES['card'])) {
            $cardData =  $this->qm->upload('./external/uploads/', 'card');
        }

        if (!empty($_FILES['pimage']['name'])) {
            $pimageData =  $this->qm->upload('./external/uploads/', 'pimage', 'jpg|jpeg|png|jpg|gif|pdf');
        }

        $insertData = [
            'cid' => $data['cid'],
            'pid' => $data['pid'],
            'eid' => $eid,
            'card' => (isset($cardData) && !empty($cardData)) ? $cardData : NULL,
            'pimage' => (isset($pimageData) && !empty($pimageData)) ? $pimageData : NULL,
            'emp_id' => $existingEmp->emp_id,
            'name' => $data['name'],
            'email' => (isset($data['email']) && !empty($data['email'])) ? $data['email'] : NULL,
            'phone' => (isset($data['phone']) && !empty($data['phone'])) ? $data['phone'] : NULL,
            'reltype' => $data['reltype'],
            'gender' => $data['gender'],
            'wedd_date' => (isset($data['wedd_date']) && !empty($data['wedd_date'])) ? date('Y-m-d', strtotime($data['wedd_date'])) : NULL,
            'dob' => (isset($data['dob']) && !empty($data['dob'])) ? date('Y-m-d', strtotime($data['dob'])) : NULL,
            'age' => (isset($data['age']) && ($data['age'] != '')) ? $data['age'] : NULL,
            'dol' => (isset($data['dol']) && !empty($data['dol'])) ? date('Y-m-d', strtotime($data['dol'])) : NULL,
            'mode' => $mode,
            'hr_approval_date' => NULL,
            'status' => $status,
            'updated_on' => date('Y-m-d H:i:s'),
            'reson' => (isset($data['reson']) && !empty($data['reson'])) ? $data['reson'] : NULL,
        ];

        $lastId = $this->qm->insert('ri_dependent_tbl', $insertData);

        if ($data['reltype'] == 'Kid') {
            updateKidIndex($data['cid'], $data['pid'], $eid, $data['reltype']);
        }

        return ($lastId) ? $lastId : false;
    }

    public function updateDependent($eid, $data, $isAdmin = false)
    {
        $existingDep = $this->qm->single('ri_dependent_tbl', "*", ['did' => $data['did']]);

        if (empty($existingDep)) {
            return false;
        }

        $existingEmp = $this->qm->single('ri_employee_tbl', "*", ['eid' => $eid]);

        if (!$existingEmp) {
            return false;
        }

        if ($existingDep->status == 1 || $existingDep->status == 0) {
            $this->addEmployeeVersion($existingDep, 'dep');
        }

        $mode = ($existingDep->status != 3) ? 'Correction' : $existingDep->mode;
        $status = 3;

        if ($isAdmin) {
            $status = 1;
            $this->deleteEmployeeVersion($existingDep->eid, 'dep');
        }

        if (isset($_FILES['card']) && !empty($_FILES['card'])) {
            $cardData =  $this->qm->upload('./external/uploads/', 'card');
        }

        if (!empty($_FILES['pimage']['name'])) {
            $pimageData =  $this->qm->upload('./external/uploads/', 'pimage', 'jpg|jpeg|png|jpg|gif|pdf');
        }

        $insertData = [
            'card' => (isset($cardData) && !empty($cardData)) ? $cardData : $existingDep->card,
            'pimage' => (isset($pimageData) && !empty($pimageData)) ? $pimageData : $existingDep->pimage,
            'emp_id' => $existingEmp->emp_id,
            'name' => $data['name'],
            'email' => (isset($data['email']) && !empty($data['email'])) ? $data['email'] : $existingDep->email,
            'phone' => (isset($data['phone']) && !empty($data['phone'])) ? $data['phone'] : $existingDep->phone,
            'reltype' => $data['reltype'],
            'gender' => $data['gender'],
            'wedd_date' => (isset($data['wedd_date']) && !empty($data['wedd_date'])) ? date('Y-m-d', strtotime($data['wedd_date'])) : $existingDep->wedd_date,
            'dob' => (isset($data['dob']) && !empty($data['dob'])) ? date('Y-m-d', strtotime($data['dob'])) : $existingDep->dob,
            'age' => (isset($data['age']) && ($data['age'] != '')) ? $data['age'] : $existingDep->age,
            'dol' => (isset($data['dol']) && !empty($data['dol'])) ? date('Y-m-d', strtotime($data['dol'])) : $existingDep->dol,
            'mode' => $mode,
            'hr_approval_date' => NULL,
            'status' => $status,
            'updated_on' => date('Y-m-d H:i:s'),
            'reson' => (isset($data['reson']) && !empty($data['reson'])) ? $data['reson'] : NULL,
        ];

        $lastId = $this->qm->update('ri_dependent_tbl', $insertData, ['did' => $data['did']]);

        if ($data['reltype'] == 'Kid') {
            updateKidIndex($existingDep->cid, $existingDep->pid, $existingDep->eid, $data['reltype']);
        }

        return ($lastId) ? true : false;
    }

    public function addEmployeeVersion($data, $type = 'emp')
    {
        if ($type == 'emp') {
            $existingRec = $this->qm->all('ri_employee_updates_tbl', '*', ['type' => $type, 'tbl_id' => $data->eid]);
            $insertData = [
                'type' => $type,
                'tbl_id' => $data->eid,
                'data' => json_encode($data)
            ];
        } else {
            $existingRec = $this->qm->all('ri_employee_updates_tbl', '*', ['type' => $type, 'tbl_id' => $data->did]);
            $insertData = [
                'type' => $type,
                'tbl_id' => $data->did,
                'data' => json_encode($data)
            ];
        }
        if ($existingRec) {
            foreach ($existingRec as $er) {
                $this->qm->delete('ri_employee_updates_tbl', ['id' => $er->id]);
            }
        }
        $this->qm->insert('ri_employee_updates_tbl', $insertData);
        return true;
    }

    public function deleteEmployeeVersion($tbl_id, $type = 'emp')
    {
        $existingRec = $this->qm->all('ri_employee_updates_tbl', '*', ['type' => $type, 'tbl_id' => $tbl_id]);
        if ($existingRec) {
            foreach ($existingRec as $er) {
                $this->qm->delete('ri_employee_updates_tbl', ['id' => $er->id]);
            }
        }
        return true;
    }

    public function revertEmployeeVersion($tbl_id, $type = 'emp')
    {
        $existingRec = $this->qm->single('ri_employee_updates_tbl', '*', ['type' => $type, 'tbl_id' => $tbl_id]);
        if ($existingRec) {
            if ($type == 'emp') {
                $this->qm->update('ri_employee_tbl', json_decode($existingRec->data, true), ['eid' => $existingRec->tbl_id]);
            }
            if ($type == 'dep') {
                $this->qm->update('ri_dependent_tbl', json_decode($existingRec->data, true), ['did' => $existingRec->tbl_id]);
                $newData = json_decode($existingRec->data, true);
                if ($newData['reltype'] == 'Kid') {
                    updateKidIndex($newData['cid'], $newData['pid'], $newData['eid'], $newData['reltype']);
                }
            }
        }
        $this->deleteEmployeeVersion($tbl_id, $type);
        return true;
    }
}
