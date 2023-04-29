<?php
class QueryModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insert($table, $dataArr)
    {
        // var_dump($table);
        echo $table;
        // print_r($this->db->insert($table, $dataArr));
        die("db");
        if ($this->db->insert($table, $dataArr)) {
            //$this->db->last_query();
            return $this->db->insert_id();
        }
    }

    public function update($table, $dataArr, $where)
    {
        $this->db
            ->set($dataArr)
            ->where($where)
            ->update($table);
        //echo $this->db->last_query();
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
    }

    public function delete($table, $where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
        //echo $this->db->last_query();
    }

    function single($table, $column = "*", $where = null)
    {
        $query = $this->db
            ->select($column)
            ->from($table)
            ->where($where)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (!empty($column)) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
        //echo $this->last->query();
    }

    public function all($table, $column = "*",  $where = "1=1", $srcharr = '', $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0)
    {

        $searchArr = array("'.$srcharr.'" => '');
        $query = $this->db
            ->select($column, FALSE)
            ->from($table)
            ->where($where)
            ->like($searchArr, FALSE, $searchType)
            ->order_by($orderColumn, $orderBy)
            ->group_by($groupBy)
            ->limit($limit, $offset)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    //    public function countRec($table, $where = null) {
    //        $this->db->where($where);
    //        $count =  $this->db->count_all_results($table);
    //        //echo $this->db->last_query();
    //        return $count;
    //    }
    //    
    //    public function getFoundRows(){
    //        $query = $this->db->query("select FOUND_ROWS() AS total");
    //        $row = $query->row();
    //        //$this->db->last_query();
    //	return $row->total;
    //    }


    /*
     * To join multiple tables
     * $table = "product_category as pcat";
     * $columnArr = array('pcat.category', 'pro.NameProduct', 'pro.IdProduct', 'cat.NameCategory', 'cat.IdCategory', 'pri.ProductPrice');        
       $dataArr = array
         ('product as pro' => 'pcat.IdProduct = pro.IdProduct',
          'category as cat' => 'pcat.IdCategory = cat.IdCategory',
          'price as pri' => 'pcat.IdPrice = pri.IdPrice'
         );
     */

    public function join($table, $columnArr, $dataArr, $joinType = 'INNER', $where = NULL, $searchArr = array(), $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0, $resultType = null)
    {
        $cnt = 0;
        // print_r($this->session->userdata());
        foreach ($columnArr as $columns) {
            $cnt++;
            /*if($cnt == 1){
                $this->db->select("SQL_CALC_FOUND_ROWS ".$columns, FALSE);
            } else {
                $this->db->select($columns);
            }  */
            $this->db->select($columns);
            //$this->db->select($columns, FALSE);
        }
        $this->db->from($table);
        foreach ($dataArr as $key => $value) {
            $this->db->join($key, $value, $joinType);
        }
        $this->db->where($where);
        //$this->db->like($searchArr, FALSE, $searchType);
        $this->db->order_by($orderColumn, $orderBy);
        $this->db->group_by($groupBy);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($resultType == 'row') {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    public function testme()
    {
        echo "This is testing section";
    }

    public function upload($url, $name, $exe = "'jpg|jpeg|png|jpg|gif'")
    {

        $config['upload_path'] = $url;
        $config['allowed_types'] = $exe;
        $config['file_name'] = $_FILES[$name]['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name)) {
            $uploadData = $this->upload->data();
            return $picture = $uploadData['file_name'];
        } else {
            return $picture = '';
        }
    }

    public function multiupload($url, $name, $exe = "'jpg|jpeg|pdf|jpg|gif'")
    {
        $config['upload_path'] = $url;
        $config['allowed_types'] = $exe;
        $config['file_name'] = $_FILES[$name]['name'];
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload($name)) {
            $uploadData = $this->upload->data();
            return $picture = $uploadData['file_name'];
        } else {
            return $picture = '';
        }
    }

    public function newdb123()
    {
        $db2 = $this->load->database('db2', true);
        $query = $db2->get("ad_policy");
        return $query->result();
    }

    public function all2($table, $column = "*",  $where = "1=1", $srcharr = '', $searchType = 'both', $groupBy = '', $orderColumn = '', $orderBy = 'ASC', $limit = NULL, $offset = 0)
    {
        $db2 = $this->load->database('db2', true);
        $searchArr = array("'.$srcharr.'" => '');
        $query = $db2
            ->select($column, FALSE)
            ->from($table)
            ->where($where)
            ->like($searchArr, FALSE, $searchType)
            ->order_by($orderColumn, $orderBy)
            ->group_by($groupBy)
            ->limit($limit, $offset)
            ->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    public function single2($table, $column = "*", $where = null)
    {
        $db2 = $this->load->database('db2', true);
        $query = $db2
            ->select($column)
            ->from($table)
            ->where($where)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (@count($column) > 1) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
        //echo $this->last->query();
    }

    public function get_files($policy_id)
    {
        $db2 = $this->load->database('db2', true);
        $db2->select('pf.ad_policy_file_id,f.file_name,pfs.policy_file_name');
        $db2->from('ad_policy_file pf');
        $db2->join('ad_crm_files f', 'f.file_id = pf.file_id', 'left');
        $db2->join('ad_policy_file_setup pfs', 'pfs.policy_file_id = pf.policy_file_id', 'left');
        $db2->where('pf.policy_id', $policy_id);
        $db2->where('pfs.policy_file_name', 'New Policy');
        $q = $db2->get();
        return ($q->num_rows() < 1) ? 0 : $q->row();
    }

    public function get_end_files($endorsement_id)
    {
        $db2 = $this->load->database('db2', true);
        $db2->select('ef.ad_endorsement_file_id,f.file_name,efs.endorsement_file_name');
        $db2->from('ad_endorsement_file ef');
        $db2->join('ad_crm_files f', 'f.file_id = ef.file_id', 'left');
        $db2->join('ad_endorsement_file_setup efs', 'efs.endorsement_file_id = ef.endorsement_file_id', 'left');
        $db2->where('ef.endorsement_id', $endorsement_id); //ad_endorsement_file_id
        $db2->where('ef.endorsement_file_id', '6');
        $q = $db2->get();
        return ($q->num_rows() < 1) ? null : $q->result();
    }

    public function getDays($table, $column = "*", $where = null, $orderColumn = '', $orderBy = 'DESC', $limit = NULL, $offset = 0)
    {
        $query = $this->db
            ->select($column)
            ->from($table)
            ->where($where)
            ->order_by($orderColumn, $orderBy)
            ->limit($limit, $offset)
            ->get();
        if ($column == "*") {
            //echo $this->last->query();
            return $query->row();
        } else if (!empty($column)) {
            return $query->row();
        } else {
            return $query->row()->$column;
        }
    }

    // public function excel($heading_name, $mapped_field, $font_style, $font_color, $font_size, $cell_fill_color, $modific)
    // {
    //     // php spreadsheet
    //     $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    //     // Set active sheet
    //     $sheet = $spreadsheet->getActiveSheet();
    //     //column names
    //     $fieldName = array("Heading Name", "Mapped With", "Font Style", "Font Color", "Font Size", "Cell Fill Color", "Modificatio");
    //     $sheet->fromArray($fieldName, null, 'A1');
    //     // Add data rows
    //     if (count($heading_name) != 0) {
    //         foreach ($heading_name as $index => $heading) {
    //             $mapField = $mapped_field[0];
    //             $fontFamily = $font_style[0];
    //             $fontColor = $font_color[0];
    //             $fontSize = $font_size[0];
    //             $fillColor = $cell_fill_color[0];
    //             $modificField = $modific[0];
    //             // Create an array with the row data
    //             $rowData = array(
    //                 $heading,
    //                 $mapField,
    //                 $fontFamily,
    //                 $fontColor,
    //                 $fontSize,
    //                 $fillColor,
    //                 $modificField,
    //             );
    //             // Set the cell styles
    //             $cellStyle = $sheet->getStyle('A' . ($index + 2) . ':H' . ($index + 2));
    //             $cellStyle->getFont()->setName($fontFamily);
    //             $cellStyle->getFont()->setSize($fontSize);
    //             $cellStyle->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($fontColor));
    //             $cellStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($fillColor);

    //             // Add the row data to the sheet
    //             $sheet->fromArray($rowData, null, 'A' . ($index + 2));
    //         }
    //     }
    //     // Set the column widths
    //     foreach (range('A', 'H') as $columnID) {
    //         $sheet->getColumnDimension($columnID)
    //             ->setAutoSize(true);
    //     }
    //     // Set download headers
    //     $fileName = "excel.xlsx";
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="' . $fileName . '"');
    //     header('Cache-Control: max-age=0');
    //     // Save spreadsheet as Excel file and output to browser
    //     $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    //     $writer->save('php://output');
    // }
    public function excel($heading_name, $mapped_field, $font_style, $font_color, $font_size, $cell_fill_color, $modific)
    {
        // php spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Set active sheet
        $sheet = $spreadsheet->getActiveSheet();
        //column names
        $fieldName = array("Heading Name", "Mapped With", "Font Style", "Font Color", "Font Size", "Cell Fill Color", "Modification");

        // Set cell styles for each column header
        $columnCount = count($fieldName);
        for ($i = 1; $i <= $columnCount; $i++) {
            $cell = $sheet->getCellByColumnAndRow($i, 1);
            $cell->setValue($fieldName[$i - 1]);
            $cell->getStyle()->getFont()->setBold(true);
            $cell->getStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $cell->getStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCCCC');
            $cell->getStyle()->getFont()->setSize(12);
        }

        // Add data rows
        if (count($heading_name) != 0) {
            foreach ($heading_name as $index => $heading) {
                $mapField = $mapped_field[$index];
                $fontStyle = $font_style[$index];
                $fontColor = $font_color[$index];
                $fontSize = $font_size[$index];
                $fillColor = $cell_fill_color[$index];
                $modificField = $modific[$index];

                $sheet->setCellValue('A' . ($index + 2), $heading)
                    ->setCellValue('B' . ($index + 2), $mapField)
                    ->setCellValue('C' . ($index + 2), $fontStyle)
                    ->setCellValue('D' . ($index + 2), $fontColor)
                    ->setCellValue('E' . ($index + 2), $fontSize)
                    ->setCellValue('F' . ($index + 2), $modificField);

                // Set cell styles for each data row
                $cell = $sheet->getCellByColumnAndRow(1, $index + 2);
                $cell->getStyle()->getFont()->setName($fontStyle);
                $cell->getStyle()->getFont()->setSize($fontSize);
                $cell->getStyle()->getFont()->getColor()->setARGB("FF8080");
                $cell->getStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB($fillColor);
            }
        }

        // Set download headers
        $fileName = "excel.xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Save spreadsheet as Excel file and output to browser
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
