package com.example.quocchi.shipper_app;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.text.InputType;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.concurrent.ScheduledFuture;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class MainActivity extends AppCompatActivity {

    EditText edt_user, edt_password;
    Button btn_register, btn_login, btn_logout;
    String username, password;
    //ScheduledThreadPoolExecutor executor = new ScheduledThreadPoolExecutor(15); // no
    ScheduledFuture<?> t;


    private String hostname = "luxexpress.cf";
    //public int position_index = -1;

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
        //btn_register = (Button)findViewById(R.id.btn_register);
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

//            btn_register.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    t.cancel(false);
//                }
//            });

            btn_login.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    //Login_Token.token;
                    //order_show();
                    //send_post();

                    //Shipper_Position_Send a = new Shipper_Position_Send(getBaseContext());


                    //t = executor.scheduleAtFixedRate(new MyTask(), 0, 2, TimeUnit.SECONDS);
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

                                                order_show();
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


        }catch (Exception e){
            Log.e("abc","EXCEPTION CAUGHT WHILE EXECUTING DATABASE TRANSACTION");
            e.printStackTrace();
        }
    }
        private void order_show(){
            //Intent intent = new Intent(MainActivity.this, History_Activity.class);
            //Intent intent = new Intent(MainActivity.this, Order_Activity.class);
            //Intent intent = new Intent(MainActivity.this, Order_Received_Activity.class);
            //Intent intent = new Intent(MainActivity.this, MapsActivity.class);
            //Intent intent = new Intent(MainActivity.this, Fragment_Activity.class);
            Intent intent = new Intent(MainActivity.this, Home_Activity.class);

            startActivity(intent);
        }

        private void send_post(){

            OkHttpClient client = new OkHttpClient();

            RequestBody requestBody = new MultipartBody.Builder()
                    .setType(MultipartBody.FORM)
                    .addFormDataPart("your_name_input", "your_value")
                    .build();

            Request request = new Request.Builder()
                    //.url("http://192.168.1.16:8000/api/shipper/showOrder")
                    .url(" http://192.168.0.132:8000/api/shipper/showOrder")
                    .post(requestBody)
                    //.addHeader("name_your_token", "your_token")
                    .build();

            client.newCall(request).enqueue(new Callback() {
                @Override
                public void onFailure(Call call, IOException e) {
                    e.printStackTrace();
                }

                @Override
                public void onResponse(Call call, Response response) throws IOException {
                    final String yourResponse = response.body().string();

                    if(response.isSuccessful()){

                        MainActivity.this.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                JSONObject Jobject = null;
                                try {
                                    Jobject = new JSONObject(yourResponse);

                                    JSONArray Jarray = Jobject.getJSONArray("data");


                                    for (int i = 0; i < Jarray.length(); i++) {
                                        JSONObject object = Jarray.getJSONObject(i);
                                        Log.w("myApp", object.getString("billOfLading"));
                                    }



                                } catch (JSONException e) {
                                    e.printStackTrace();
                                }



                                Toast.makeText(MainActivity.this, "Ok: "+Jobject.toString(),Toast.LENGTH_SHORT).show();
                            }
                        });
                    }else{
                        MainActivity.this.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                Toast.makeText(MainActivity.this, "Ok: "+yourResponse,Toast.LENGTH_SHORT).show();
                            }
                        });
                    }


                }
            });
        }

    class MyTask implements Runnable {

        public void run() {
            send_lat_long();
        }
    }

    private void send_lat_long(){

        OkHttpClient client = new OkHttpClient();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("order_id", "2")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.1.16:8000/api/shipper/showOrder")
                .url(" http://192.168.0.132:8000/api/ordertrakings/insertPosition")
                .post(requestBody)
                //.addHeader("name_your_token", "your_token")
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if(response.isSuccessful()){

                }else{

                }


            }
        });
    }
}
