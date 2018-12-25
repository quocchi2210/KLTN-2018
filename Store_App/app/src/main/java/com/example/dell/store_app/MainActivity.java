package com.example.dell.store_app;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.InputType;
import android.util.Log;
import android.util.TypedValue;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class MainActivity extends AppCompatActivity {

    private TextView txt_forgot_password;
    private EditText edt_user, edt_password;
    private Button btn_register, btn_login, btn_logout;
    private String username, password;

    private String hostname = "luxexpress.cf";
    //public int position_index = -1;
    String token = Login_Token.token;

    CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

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

        edt_password.setInputType(InputType.TYPE_CLASS_TEXT | InputType.TYPE_TEXT_VARIATION_PASSWORD);
        btn_login = (Button)findViewById(R.id.btn_login);
        btn_register = (Button)findViewById(R.id.btn_register);
        btn_logout = (Button)findViewById(R.id.btn_logout);

        txt_forgot_password = (TextView)findViewById(R.id.txt_forgot_password);
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
                    Intent intent = new Intent(getBaseContext(), Register_Activity.class);
                    startActivity(intent);
                }
            });

            btn_login.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    //show();
                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("type", "Email")
                            .addFormDataPart("email", edt_user.getText().toString())
                            .addFormDataPart("password", edt_password.getText().toString())
                            .build();

                    Request request = new Request.Builder()
                            .url("https://luxexpress.cf/api/login")
                            //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
                            .post(requestBody)
                            .build();

                    client.newCall(request).enqueue(new Callback() {
                        @Override
                        public void onFailure(Call call, IOException e) {
                            e.printStackTrace();
                        }

                        @Override
                        public void onResponse(Call call, Response response) throws IOException {
                            final String yourResponse = response.body().string();

                            if (response.isSuccessful()) {

                                MainActivity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {

                                            Jobject = new JSONObject(yourResponse);

                                            Login_Token.token = Jobject.getString("token");
                                            Log.w("Login: ", yourResponse.toString());
                                            Log.w("Login Token: ",  Login_Token.token);

                                            if(Login_Token.token != null){

                                                show();
                                                //send_post();

                                                //t = executor.scheduleAtFixedRate(new MyTask(), 0, 2, TimeUnit.SECONDS);
                                            }

                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }

                                    }
                                });
                            } else {
                                Log.w("Login:", yourResponse.toString());
                            }


                        }
                    });

                }
            });

            txt_forgot_password.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                   //Toast.makeText(MainActivity.this, "Ok: forgot link ",Toast.LENGTH_SHORT).show();
                    android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(MainActivity.this, android.app.AlertDialog.THEME_HOLO_LIGHT);

                    LayoutInflater inflater = MainActivity.this.getLayoutInflater();
                    final View forgot_view = inflater.inflate(R.layout.forgot_password, null);

                    builder.setView(forgot_view);

                    DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialog, int which) {
                            switch(which){
                                case DialogInterface.BUTTON_POSITIVE:
                                    // User clicked the Yes button
                                    //Toast.makeText(MainActivity.this, "OK CON TE TE", Toast.LENGTH_SHORT).show();

                                    EditText email = (EditText) forgot_view.findViewById(R.id.email);

                                    RequestBody requestBody = new MultipartBody.Builder()
                                            .setType(MultipartBody.FORM)
                                            .addFormDataPart("email", email.getText().toString())
                                            .build();

                                    Request request = new Request.Builder()
                                            .url("https://luxexpress.cf/api/user/reset")
                                            .post(requestBody)
                                            .addHeader("Authorization", "Bearer " + token)
                                            .build();

                                    client.newCall(request).enqueue(new Callback() {
                                        @Override
                                        public void onFailure(Call call, IOException e) {
                                            e.printStackTrace();
                                        }

                                        @Override
                                        public void onResponse(Call call, Response response) throws IOException {
                                            final String yourResponse = response.body().string();

                                            if (response.isSuccessful()) {

                                                MainActivity.this.runOnUiThread(new Runnable() {
                                                    @Override
                                                    public void run() {
                                                        JSONObject Jobject = null;
                                                        try {

                                                            Jobject = new JSONObject(yourResponse);
                                                            String error = Jobject.getString("error");

                                                            if(error.contains("true")){
                                                                Toast.makeText(MainActivity.this, "Mật khẩu mới đã được gửi đến mail của bạn.", Toast.LENGTH_SHORT).show();
                                                            }
                                                            Log.w("Forgot ", yourResponse.toString());

                                                        } catch (JSONException e) {
                                                            e.printStackTrace();
                                                            Log.w("Forgot ", yourResponse.toString());
                                                            Log.w("Forgot ",  e.toString());
                                                        }

                                                    }
                                                });
                                            } else {
                                                Log.w("Forgot ", yourResponse.toString());
                                            }


                                        }
                                    });


                                    break;

                                case DialogInterface.BUTTON_NEGATIVE:
                                    // User clicked the No button
                                    break;
                            }
                        }
                    };

                    builder.setPositiveButton("OK" ,dialogClickListener);

                    android.app.AlertDialog dialog = builder.create();
                    dialog.setTitle("Quên mật khẩu");

                    dialog.show();
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
        //Intent intent = new Intent(MainActivity.this, Register_Activity.class);
        //Intent intent = new Intent(MainActivity.this, Updateprofile_Activity.class);
        startActivity(intent);
    }


}
