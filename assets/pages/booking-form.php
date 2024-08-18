         <div class="col-md-6 col-md-offset-3">
             <?php echo isset($msg); ?>
             <form action="" method="post">
                 <div class="form-group">
                     <label for="Name">Name</label>
                     <input type="text" class="form-control" name="name">
                 </div>
                 <div class="form-group">
                     <label for="E-mail">Email</label>
                     <input type="email" class="form-control" name="email">
                 </div>
                 <div class="form-group">
                     <label for=subject">Subject</label>
                     <input type="text" class="form-control" name="subject">
                 </div>
                 <div class="form-group">
                     <label for=student">Student</label>
                     <input type="text" class="form-control" name="student">
                 </div>
                 <div class="form-group">
                     <label for=type">Type</label>
                     <input type="text" class="form-control" name="type">
                 </div>
                 <div class="form-group">
                     <label for=timeslot">Timeslot</label>
                     <input type="text" class="form-control" name="timeslot">
                 </div>
                 <div class="form-group">
                     <label for=uid">Account Holder</label>
                     <input type="text" class="form-control" name="uid">
                 </div>
                 <div class="form-group">
                     <label for=location">Location</label>
                     <input type="text" class="form-control" name="location">
                 </div>
                 <button class="btn btn-action" type="submit" name="submit-booking">Submit</button>
             </form>
         </div>