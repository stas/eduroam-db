<?php
    class mon_sers_controller {
        
        function index() {
            $realms = new Realm();
            $m = new Mon_ser();
            pass_var("realms", $realms->find_all());
            pass_var("m", $m->find_all());
            pass_var('title', "Monitored servers Index");
            pass_var('message', "List of monitored servers");
        }
        
        function add() {
            $r = new Realm();
            $r = $r->find_all();
            $rids = array();
            foreach($r as $realm) {
                $rids[$realm->id] = $realm->org_name;
            }
            
            if($_POST["action"] == "addmonser") {
                $data = $_POST;
                unset($data["action"]);
                unset($data["addmonser"]);
                $data["ts"] = date("Y-m-d");
                $m = new Mon_ser($data);
                $m->save();
            }
            pass_var("rids",$rids);
            pass_var('title', "Add a monitored server");
            pass_var('message', "Add a monitored server");
        }
        
        function delete() {
            global $runtime;
            $i = new Mon_ser();
            $i = $i->find_one_by_id($runtime['ident']);
            $i->delete();
            redirect('mon_sers/');
        }
        
        function edit() {
            $r = new Realm();
            $r = $r->find_all();
            $rids = array();
            foreach($r as $realm) {
                $rids[$realm->id] = $realm->org_name;
            }
            
            if($_POST["action"] == "updatemonser") {
                global $runtime;
                $data = $_POST;
                unset($data["action"]);
                unset($data["updatemonser"]);
                $data["ts"] = date("Y-m-d");
                $m = new Mon_ser();
                $m = $m->find_one_by_id($runtime['ident']);
                $m->data = $data;
                $m->dirty = array(
                                    'name',
                                    'mon_realmid',
                                    'ip',
                                    'port',
                                    'timeout',
                                    'retry',
                                    'secret',
                                    'stype',
                                    'reject_only',
                                    'radsec',
                                    'monitoring',
                                    'last_mon_logid',
                                    'ts'
                                );
                $m->save();
                $m = $m->find_one_by_id($runtime['ident']);
                pass_var("mons", $m->data);
            }
            else {
                global $runtime;
                $m = new Mon_ser();
                $m = $m->find_one_by_id($runtime['ident']);
                pass_var("mons", $m->data);
            }
            
            pass_var("rids",$rids);
            pass_var('title', "Edit monitored server");
            pass_var('message', "Edit monitored server");
        }
    }
?>