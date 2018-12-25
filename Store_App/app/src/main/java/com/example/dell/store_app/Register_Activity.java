package com.example.dell.store_app;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Toast;

import org.json.JSONArray;
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

public class Register_Activity extends AppCompatActivity {

    private EditText txt_store_name, txt_email, txt_username, txt_password, txt_comfirmpassword;
    private Button btn_done;

    private String hostname = "luxexpress.cf";

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
        setContentView(R.layout.activity_register);

        map_gui();

        btn_done.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                //Toast.makeText(Register_Activity.this, "Ok: Register Store work ",Toast.LENGTH_SHORT).show();
                send_post();
            }
        });
    }

    private void map_gui(){
        txt_store_name = (EditText) findViewById(R.id.txt_store_name);
        txt_email = (EditText) findViewById(R.id.txt_email);
        txt_username = (EditText) findViewById(R.id.txt_username);
        txt_password = (EditText) findViewById(R.id.txt_password);
        txt_comfirmpassword = (EditText) findViewById(R.id.txt_comfirmpassword);
        btn_done = (Button) findViewById(R.id.btn_done);
    }

    private void send_post(){
        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", txt_store_name.getText().toString())
                .addFormDataPart("email", txt_email.getText().toString())
                .addFormDataPart("username", txt_username.getText().toString())
                .addFormDataPart("password", txt_password.getText().toString())
                //.addFormDataPart("password", txt_comfirmpassword.toString())
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/register")
                //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
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

                    Register_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {

                               Jobject = new JSONObject(yourResponse);
//
//                                JSONArray Jarray = Jobject.getJSONArray("data");
//
//                                for (int i = 0; i < Jarray.length(); i++) {
//                                    JSONObject object = Jarray.getJSONObject(i);
//                                    Log.w("myApp", object.toString());
//                                    String billOfLading = object.getString("billOfLading");
//                                    String address = object.getString("addressReceiver");
//                                    String idOrder = object.getString("idOrder");
//                                    String idOrderStatus = object.getString("idOrderStatus");
//                                    data.add(new Order(billOfLading, address, idOrder, idOrderStatus));
//                                }

                                Log.w("Register ", yourResponse.toString());

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });
                } else {
                    Log.w("myApp", yourResponse.toString());
                }


            }
        });

    }

}
