package com.example.dell.store_app;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class MainActivity extends AppCompatActivity {

    EditText edt_user, edt_password;
    Button btn_register, btn_login, btn_logout;
    String username, password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        try{

            mapped_gui();
            control_button();
        }catch (Exception e){
            Log.e("abcd","EXCEPTION CAUGHT WHILE EXECUTING DATABASE TRANSACTION");
            e.printStackTrace();
        }
    }

    private void mapped_gui(){
        edt_user = (EditText)findViewById(R.id.edit_text_user);
        edt_password = (EditText)findViewById(R.id.edit_text_password);
        btn_login = (Button)findViewById(R.id.btn_login);
        btn_register = (Button)findViewById(R.id.btn_register);
        btn_logout = (Button)findViewById(R.id.btn_logout);
    }

    private void control_button(){
        try{
            btn_logout.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View view){
                    AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this, android.R.style.Theme_DeviceDefault_Light_Dialog);
                    builder.setTitle("Bạn có chắc muốn thoát khỏi chương trình.");
                    builder.setMessage("Hãy lựa chọn bên dưới để xác nhận");
                    builder.setIcon(android.R.drawable.ic_dialog_alert);

                    builder.setPositiveButton("Có", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            onBackPressed();
                        }
                    });

                    builder.setNegativeButton("Không", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {

                        }
                    });

                    builder.show();
                }
            });

            btn_register.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {

                }
            });

            btn_login.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    show();
                }
            });


        }catch (Exception e){
            Log.e("abc","EXCEPTION CAUGHT WHILE EXECUTING DATABASE TRANSACTION");
            e.printStackTrace();
        }
    }

    private void show(){
        Intent intent = new Intent(MainActivity.this, Store_Manage_Activity.class);
        //Intent intent = new Intent(MainActivity.this, Add_Activity.class);
        startActivity(intent);
    }
}
