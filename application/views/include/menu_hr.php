<?php if($this->permission1->method('add_designation','create')->access() || $this->permission1->method('manage_designation','read')->access() || $this->permission1->method('add_employee','create')->access() || $this->permission1->method('manage_employee','read')->access() ||$this->permission1->method('add_person','create')->access() || $this->permission1->method('add_loan','create')->access() || $this->permission1->method('add_payment','create')->access() || $this->permission1->method('manage_person','read')->access()||$this->permission1->method('add_attendance','create')->access() || $this->permission1->method('manage_attendance','read')->access() || $this->permission1->method('attendance_report','read')->access() || $this->permission1->method('add_benefits','create')->access() || $this->permission1->method('manage_benefits','read')->access() || $this->permission1->method('add_salary_setup','create')->access() || $this->permission1->method('manage_salary_setup','read')->access() || $this->permission1->method('salary_generate','create')->access() || $this->permission1->method('manage_salary_generate','read')->access() || $this->permission1->method('salary_payment','create')->access() || $this->permission1->method('add_expense_item','create')->access() || $this->permission1->method('manage_expense_item','read')->access() || $this->permission1->method('add_expense','create')->access() || $this->permission1->method('manage_expense','read')->access() || $this->permission1->method('add_ofloan_person','create')->access() || $this->permission1->method('add_office_loan','create')->access() || $this->permission1->method('add_loan_payment','create')->access() || $this->permission1->method('manage_ofln_person','read')->access()){?>
            <!-- Supplier menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm") || $this->uri->segment('1') == ("Cattendance") || $this->uri->segment('1') == ("Cpayroll") || $this->uri->segment('1') == ("Cexpense") || $this->uri->segment('1') == ("Cloan") || $this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("manage_person") || $this->uri->segment('2') == ("person_loan_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users"></i><span><?php echo display('hrm_management') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
       <?php if($this->permission1->method('add_designation','create')->access() || $this->permission1->method('manage_designation','read')->access() || $this->permission1->method('add_employee','create')->access() || $this->permission1->method('manage_employee','read')->access()){?>
            <!-- Supplier menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Chrm")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-users"></i><span><?php echo display('hrm') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
         <?php if($this->permission1->method('add_designation','create')->access()){ ?>          
          <li class="treeview <?php if ($this->uri->segment('2') == ("add_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_designation') ?>"><?php echo display('add_designation') ?></a></li>
     <?php } ?>
         <?php if($this->permission1->method('manage_designation','read')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_designation")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_designation') ?>"><?php echo display('manage_designation') ?></a></li>
                          <?php } ?>
        <?php if($this->permission1->method('add_employee','create')->access()){ ?>
                         <li class="treeview <?php if ($this->uri->segment('2') == ("add_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/add_employee') ?>"><?php echo display('add_employee') ?></a></li>
                    <?php } ?>
            <?php if($this->permission1->method('manage_employee','read')->access()){ ?>        
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_employee")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Chrm/manage_employee') ?>"><?php echo display('manage_employee') ?></a></li> 
                          <?php } ?> 
                 
                </ul>
            </li>
        <?php } ?>


              <!-- ================== Attendance menu start ================= -->
            <?php if($this->permission1->method('add_attendance','create')->access() || $this->permission1->method('manage_attendance','read')->access() || $this->permission1->method('attendance_report','read')->access()){?>
                          <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cattendance")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-clock-o"></i><span><?php echo display('attendance') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
         <?php if($this->permission1->method('add_attendance','create')->access()){ ?>       
               <li class="treeview <?php if ($this->uri->segment('2') == ("add_attendance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/add_attendance') ?>"><?php echo display('add_attendance') ?></a></li>
           <?php } ?>
        <?php if($this->permission1->method('manage_attendance','read')->access()){ ?>   
                         <li class="treeview <?php if ($this->uri->segment('2') == ("manage_attendance")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/manage_attendance') ?>"><?php echo display('manage_attendance') ?></a></li> 
                          <?php } ?>
        <?php if($this->permission1->method('attendance_report','read')->access()){ ?>  
                          <li class="treeview <?php if ($this->uri->segment('2') == ("attendance_report")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cattendance/attendance_report') ?>"><?php echo display('attendance_report') ?></a></li> 
                          <?php } ?>
                </ul>
            </li>
              <?php } ?>
               <!-- ====================== Attendance menu end ================== -->
                 
                            <!-- ========================== Payroll menu start =================== -->
                    <?php if($this->permission1->method('add_benefits','create')->access() || $this->permission1->method('manage_benefits','read')->access() || $this->permission1->method('add_salary_setup','create')->access() || $this->permission1->method('manage_salary_setup','read')->access() || $this->permission1->method('salary_generate','create')->access() || $this->permission1->method('manage_salary_generate','read')->access() || $this->permission1->method('salary_payment','create')->access()){?>
            <!-- Supplier menu start -->
            <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cpayroll")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-paypal"></i><span><?php echo display('payroll') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
            <?php if($this->permission1->method('add_benefits','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("Salarybenificial")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/Salarybenificial') ?>">
                        <?php echo display('add_benefits') ?></a></li><?php }?>
            <?php if($this->permission1->method('manage_benefits','read')->access()){ ?>            
                      <li class="treeview <?php if ($this->uri->segment('2') == ("manage_benefits")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_benefits') ?>"><?php echo display('manage_benefits') ?></a></li>
                      <?php }?>
             <?php if($this->permission1->method('add_salary_setup','create')->access()){ ?>          
                      <li class="treeview <?php if ($this->uri->segment('2') == ("salary_setup_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_setup_form') ?>"><?php echo display('add_salary_setup') ?></a></li>
                       <?php }?>
            <?php if($this->permission1->method('manage_salary_setup','read')->access()){ ?> 
                      <li class="treeview <?php if ($this->uri->segment('2') == ("manage_salary_setup")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_salary_setup') ?>"><?php echo display('manage_salary_setup') ?></a></li> 
                       <?php }?> 
            <?php if($this->permission1->method('salary_generate','create')->access()){ ?>            
                       <li class="treeview <?php if ($this->uri->segment('2') == ("salary_generate_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_generate_form') ?>"><?php echo display('salary_generate') ?></a></li>
                       <?php }?> 
            <?php if($this->permission1->method('manage_salary_generate','read')->access()){ ?>
                       <li class="treeview <?php if ($this->uri->segment('2') == ("manage_salary_generate")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/manage_salary_generate') ?>"><?php echo display('manage_salary_generate') ?></a></li>
                        <?php }?> 
                        <?php if($this->permission1->method('salary_payment','create')->access()){ ?>
                     <li class="treeview <?php if ($this->uri->segment('2') == ("salary_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cpayroll/salary_payment') ?>"><?php echo display('salary_payment') ?></a></li>   <?php }?> 

                </ul>
            </li>
        <?php } ?>
               <!-- =============================== Payroll menu end =================== -->
                 <!-- =======================   Expense menu start ========================= -->
         <?php if($this->permission1->method('add_expense_item','create')->access() || $this->permission1->method('manage_expense_item','read')->access() || $this->permission1->method('add_expense','create')->access() || $this->permission1->method('manage_expense','read')->access()){?>
             <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cexpense")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-credit-card"></i><span><?php echo display('expense') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                      <?php
                    if($this->permission1->method('add_expense_item','create')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("add_expense_item")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/add_expense_item') ?>"><?php echo display('add_expense_item') ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('manage_expense_item','read')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_expense_item")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/manage_expense_item') ?>"><?php echo display('manage_expense_item') ?></a></li>
                <?php }?>
                    <?php if($this->permission1->method('add_expense','create')->access()){ ?>
                    <li class="treeview <?php  if ($this->uri->segment('2') == ("add_expense")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/add_expense') ?>"><?php echo display('add_expense') ?></a></li>
                <?php } ?>
                <?php if($this->permission1->method('manage_expense','read')->access()){ ?>
                     <li class="treeview <?php  if ($this->uri->segment('2') == ("manage_expense")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/manage_expense') ?>"><?php echo display('manage_expense') ?></a></li>
                     <?php } ?>
                      <?php if($this->permission1->method('expense_statement','read')->access()){ ?>
                      <li  class="treeview <?php  if ($this->uri->segment('2') == ("expense_statement_form")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cexpense/expense_statement_form') ?>"><?php echo display('expense_statement') ?></a></li>
                  <?php }?>
                </ul>
            </li>
        <?php }?>
    <!-- ========================== Expense menu end ========================== -->

            <!-- Office loan start -->
             <?php if($this->permission1->method('add_ofloan_person','create')->access() || $this->permission1->method('add_office_loan','create')->access() || $this->permission1->method('add_loan_payment','create')->access() || $this->permission1->method('manage_ofln_person','read')->access()){?>
           <li class="treeview <?php
            if ($this->uri->segment('1') == ("Cloan") && $this->uri->segment('2') == ("add_ofloan_person") || $this->uri->segment('2') == ("manage_ofln_person") || $this->uri->segment('2') == ("person_ledger") || $this->uri->segment('2') == ("add_office_loan") || $this->uri->segment('2') == ("add_loan_payment") || $this->uri->segment('2') == ("person_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-university" aria-hidden="true"></i>

                    <span><?php echo display('office_loan') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                     <?php if($this->permission1->method('add_ofloan_person','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_ofloan_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_ofloan_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('add_office_loan','create')->access()){ ?>
                      <li class="treeview <?php if ($this->uri->segment('2') == ("add_office_loan")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_office_loan') ?>"><?php echo display('add_loan') ?></a></li>
                  <?php }?>
                   <?php if($this->permission1->method('add_loan_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_loan_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/add_loan_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('manage_ofln_person','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_ofln_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Cloan/manage_ofln_person') ?>"><?php echo display('manage_person') ?></a></li>
                <?php }?>
                </ul>
            </li> 
        <?php }?>
            <!-- Office loan end -->
            <!--  Personal loan start -->
               <?php if($this->permission1->method('add_person','create')->access() || $this->permission1->method('add_loan','create')->access() || $this->permission1->method('add_payment','create')->access() || $this->permission1->method('manage_person','read')->access()){?>
            <li class="treeview <?php
            if ($this->uri->segment('2') == ("add_person") || $this->uri->segment('2') == ("add_loan") || $this->uri->segment('2') == ("add_payment") || $this->uri->segment('2') == ("manage_person") || $this->uri->segment('2') == ("person_loan_edit")) {
                echo "active";
            } else {
                echo " ";
            }
            ?>">
                <a href="#">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <span><?php echo display('personal_loan') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if($this->permission1->method('add_person','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_person') ?>"><?php echo display('add_person') ?></a></li>
                <?php }?>
                <?php if($this->permission1->method('add_loan','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_loan")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_loan') ?>"><?php echo display('add_loan') ?></a></li>
                <?php }?>
                  <?php if($this->permission1->method('add_payment','create')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("add_payment")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/add_payment') ?>"><?php echo display('add_payment') ?></a></li>
                <?php }?>
                 <?php if($this->permission1->method('manage_person','read')->access()){ ?>
                    <li class="treeview <?php if ($this->uri->segment('2') == ("manage_person")){
                        echo "active";
                    } else {
                        echo " ";
                    }?>"><a href="<?php echo base_url('Csettings/manage_person') ?>"><?php echo display('manage_loan') ?></a></li>
                    <?php }?>
                </ul>
            </li>
        <?php }?>
            <!-- loan end -->
                </ul>
            </li>
        <?php } ?>
             <!-- Human resource management menu end -->