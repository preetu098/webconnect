<?php

class queues {

    private $CI;
    
    public function __construct() {
        $this->CI = &get_instance();
    }

    public function getEmpInviteStats($batch) {
        $allEmails = $this->CI->db->where('batch', $batch)->get('queues')->result();

        $bounce = 0;
        $sent = 0;
        $failed = 0;
        $pending = 0;

        foreach($allEmails as $email) {
            $data = json_decode($email->queue_data, true);
            if($data['status'] == 'bounce') {
                $bounce += 1;
            }
            elseif($data['status'] == 'sent') {
                $sent += 1;
            }
            elseif($data['status'] == 'failed') {
                $failed += 1;
            }
            else {
                $pending += 1;
            }
        }
        $stats = [
            'total' => count($allEmails),
            'sent' => $sent,
            'failed' => $failed,
            'bounced' => $bounce,
            'pending' => $pending
        ];
        return $stats;
    }

    public function addToQueue($data, $type) {
        $batchId = uniqid();
        switch($type) {
            case 'employee_invitation':
                foreach($data as $emp) {
                    $this->CI->db->insert('queues', [
                        'queue_type' => 'employee_invitation',
                        'queue_data' => json_encode($emp),
                        'batch' => $batchId,
                        'status' => 'queued'
                    ]);
                }
                $this->CI->db->insert('emp_invite_history', [
                    'cid' => $this->CI->session->userdata('cid'),
                    'batch' => $batchId,
                    'invite_data' => json_encode($this->getEmpInviteStats($batchId))
                ]);
                return $batchId;

            default:
                return null;
        }
    }

    public function processQueue($type) {
        $limit = 100;
        switch($type) {
            case 'employee_invitation':
                $queueItems = $this->CI->db->where('queue_type', $type)->where('status', 'queued')->order_by('id', 'asc')->limit($limit)->get('queues')->result();
                foreach($queueItems as $qItem) {
                    $this->CI->db->where('id', $qItem->id)->update('queues', [
                        'status' => 'processing'
                    ]);
                }
                foreach($queueItems as $item) {
                    $data = json_decode($item->queue_data, true);

                    $template = '<p>Dear <<employee_name>>,</p><br><p>We are happy to inform you that your company has associated with A&M 
                        Insurance Brokers specialty division Riskbirbal to manage the Employee Benefit 
                        Policies through our portal "Well Connect" a portal where you can manage your 
                        policy.</p><p>You are requested to register yourself and update your details. <a href="<<register_url>>"><strong>Click here</strong></a></p>
                        <p>Your employee ID to register <strong><<employee_id>></strong></p><p>You may contact your HR Team member for any clarification and understanding.</p>
                        <p><<hr_message>></p><p>Wish you a great health and Wellness in your life.</p><br><p>Regards,</p><p>Well Connect Team</p><p>Wellconnect@riskbirbal.com</p>';
            
                    $variables = [
                        '<<employee_name>>' => $data['emp_name'],
                        '<<hr_message>>' => $data['hr_message'],
                        '<<register_url>>' => $data['register_url'],
                        '<<employee_id>>' => $data['emp_id']
                    ];
            
                    $message = $template;

                    foreach($variables as $key=>$var) {
                        $message = str_replace($key, $var, $message);
                    }

                    $status = 'failed';
                    $data['status'] = $status;

                    $sent = send_smtp_mail('WELLCONNECT@RISKBIRBAL.COM',$data['emp_email'], 'Invitation for registration in Employee Benefit policy', $message);

                    if($sent) {
                        $status = 'sent';
                        // sleep(2);
                        $bounceStatus = getBounceStatus($data['emp_email']);
                        if($bounceStatus) {
                            $status = 'bounce';
                        }
                        $data['status'] = $status;
                        $this->CI->db->where('id', $item->id)->update('queues', [
                            'status' => 'completed',
                            'queue_data' => json_encode($data)
                        ]);
                    } else {
                        $this->CI->db->where('id', $item->id)->update('queues', [
                            'status' => 'failed',
                            'queue_data' => json_encode($data)
                        ]);
                    }

                    $this->CI->db->update('emp_invite_history', [
                        'invite_data' => json_encode($this->getEmpInviteStats($item->batch))
                    ], 'batch = "'.$item->batch.'"');

                    // $batchData = $this->CI->db->where('batch', $item->batch)->get('emp_invite_history')->row();

                    // if(!empty($batchData)) {
                    //     $this->CI->db->where('id', $batchData->id)->update('emp_invite_history', [
                    //         'invite_data' => json_encode($this->getEmpInviteStats($item->batch))
                    //     ]);
                    // }
                }

                return true;

            default:
                return true;
        }
    }
}