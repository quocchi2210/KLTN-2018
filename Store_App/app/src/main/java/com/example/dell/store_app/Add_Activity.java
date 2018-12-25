package com.example.dell.store_app;

import android.content.DialogInterface;
import android.content.Intent;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Add_Activity extends AppCompatActivity {

    EditText name_sender, address_sender, phone_sender, name_receiver, address_receiver, phone_receiver, weight;
    CheckBox cb_cod;
    Spinner spinner_des, spinner_service_type;
    Button btn_done;
    String cod = null;

    private String token = Login_Token.token;
    private String hostname = "luxexpress.cf";

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
        setContentView(R.layout.activity_add);

        mapped_gui();
        control_button();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.menu_store, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){
        Intent intent;
        switch(item.getItemId()){
            case R.id.menu_item_add_order:

                intent = new Intent(getBaseContext(), Add_Activity.class);
                startActivity(intent);

                break;
            case R.id.menu_item_manage_order:

                intent = new Intent(getBaseContext(), Store_Manage_Activity.class);
                startActivity(intent);
                break;

        }
        return super.onOptionsItemSelected(item);
    }


    private void mapped_gui() {
        name_sender = (EditText) findViewById(R.id.name_sender);
        address_sender = (EditText) findViewById(R.id.address_sender);
        phone_sender = (EditText) findViewById(R.id.phone_sender);

        OkHttpClient client = new OkHttpClient();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your", "your")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/store/showProfileStore")
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

                    Add_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {

                            JSONObject Jobject = null;
                            try {
                                ListView lv_store_mange = findViewById(R.id.list_view_store_manage);
                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp", object.toString());
                                    String name_store = object.getString("nameStore");
                                    String address_store = object.getString("addressStore");
                                    String phone_store = object.getString("phoneNumber");
                                    name_sender.setText(name_store);
                                    address_sender.setText(address_store);
                                    phone_sender.setText(phone_store);
                                }

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }


                        }
                    });
                } else {

                }

            }
        });

        name_receiver = (EditText) findViewById(R.id.name_receiver);
        address_receiver = (EditText) findViewById(R.id.address_receiver);
        phone_receiver = (EditText) findViewById(R.id.phone_receiver);

        weight = (EditText) findViewById(R.id.weight);

        cb_cod = (CheckBox) findViewById(R.id.cb_cod);

        onCheckboxClicked(cb_cod);

        spinner_des = (Spinner) findViewById(R.id.spinner_des);
        spinner_service_type = (Spinner) findViewById(R.id.spinner_service_type);

        List<String> list_des = new ArrayList<>();
        list_des.add("Cho xem hàng, không cho thử");
        list_des.add("Cho thử hàng");
        list_des.add("Không cho xem hàng");

        ArrayAdapter<String> adapter_des = new ArrayAdapter(this, android.R.layout.simple_spinner_item, list_des);
        adapter_des.setDropDownViewResource(android.R.layout.simple_list_item_single_choice);

        spinner_des.setAdapter(adapter_des);

        List<String> list_service_type = new ArrayList<>();
        list_service_type.add("Normal Delivery");
        list_service_type.add("Fast Delivery");
        list_service_type.add("Express Delivery");

        ArrayAdapter<String> adapter_service_type = new ArrayAdapter(this, android.R.layout.simple_spinner_item, list_service_type);
        adapter_service_type.setDropDownViewResource(android.R.layout.simple_list_item_single_choice);

        spinner_service_type.setAdapter(adapter_service_type);

        btn_done = (Button) findViewById(R.id.btn_done);


    }

    private void control_button() {
        try {

            btn_done.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {

                    String service_id_type = null;
                    switch (spinner_service_type.getSelectedItem().toString()) {

                        case "Normal Delivery":
                            service_id_type = "1";
                            break;
                        case "Fast Delivery":
                            service_id_type = "2";
                            break;
                        case "Express Delivery":
                            service_id_type = "3";
                            break;
                    }

                    String des = null;
                    switch (spinner_des.getSelectedItem().toString()) {

                        case "Cho xem hàng, không cho thử":
                            des = "1";
                            break;
                        case "Cho thử hàng":
                            des = "2";
                            break;
                        case "Không cho xem hàng":
                            des = "3";
                            break;
                    }

                    OkHttpClient client = new OkHttpClient();

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("name_sender", name_sender.getText().toString())
                            .addFormDataPart("address_sender", address_sender.getText().toString())
                            .addFormDataPart("phone_sender", phone_sender.getText().toString())
                            .addFormDataPart("name_receiver", name_receiver.getText().toString())
                            .addFormDataPart("address_receiver", address_receiver.getText().toString())
                            .addFormDataPart("phone_receiver", phone_receiver.getText().toString())
                            .addFormDataPart("description_order", des)
                            .addFormDataPart("cod", cod)
                            .addFormDataPart("total_weight", weight.getText().toString())
                            .addFormDataPart("id_service_type", service_id_type)
                            .build();

                    Request request = new Request.Builder()
                            .url("https://luxexpress.cf/api/store/insertOrderStore")
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
                                Log.w("Add_Activity", "Add success");
                                //Toast.makeText(Add_Activity.this, "Add success", Toast.LENGTH_SHORT).show();
                            } else {
                                Log.w("Add_Activity", "Add faild " + yourResponse.toString());
                            }

                        }
                    });
                }
            });

        } catch (Exception e) {
            Log.e("Add_Activity", "EXCEPTION CAUGHT WHILE EXECUTING DATABASE TRANSACTION");
            e.printStackTrace();
        }
    }

    public void onCheckboxClicked(View view) {
        // Is the view now checked?
        boolean checked = ((CheckBox) view).isChecked();

        // Check which checkbox was clicked
        switch (view.getId()) {
            case R.id.cb_cod:
                if (cb_cod.isChecked()) {
                    cod = "1";
                } else {
                    cod = "0";
                }


                break;
        }
    }


}
