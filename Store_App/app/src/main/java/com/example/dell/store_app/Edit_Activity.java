package com.example.dell.store_app;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.Spinner;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Edit_Activity extends AppCompatActivity {

    EditText name_sender, address_sender, phone_sender, name_receiver, address_receiver, phone_receiver, weight;
    CheckBox cb_cod;
    Spinner spinner_des, spinner_service_type;
    Button btn_done;
    String cod = null;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add);

        mapped_gui();
        control_button();
    }

    private void mapped_gui() {
        name_sender = (EditText) findViewById(R.id.name_sender);
        address_sender = (EditText) findViewById(R.id.address_sender);
        phone_sender = (EditText) findViewById(R.id.phone_sender);

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

        set_data();


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
                    //Toast.makeText(Add_Activity.this, des, Toast.LENGTH_SHORT).show();
                    //Toast.makeText(Add_Activity.this, service_id_type, Toast.LENGTH_SHORT).show();
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
                            //.url("http://192.168.1.16:8000/api/shipper/showOrder")
                            .url(" http://192.168.0.132:8000/api/store/insertOrderStore")
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

    private void set_data() {
        Intent intent = getIntent();
        String id_order = intent.getStringExtra("id_order");

        OkHttpClient client = new OkHttpClient();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("id_order", id_order)
                .build();

        Request request = new Request.Builder()
                .url("http://192.168.0.132:8000/api/store/getInfoEditFromIdorder")
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

                if (response.isSuccessful()) {

                    Edit_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {


                            JSONObject Jobject = null;
                            try {
                                ListView lv_store_mange = findViewById(R.id.list_view_store_manage);
                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                //for (int i = 0; i < Jarray.length(); i++) {
                                JSONObject object = Jarray.getJSONObject(0);
                                Log.w("myApp", object.toString());
                                String name_store = object.getString("nameStore");
                                String address_store = object.getString("addressStore");
                                String phone_store = object.getString("phoneNumber");

                                String name_receiver_str = object.getString("nameReceiver");
                                String address_receiver_str = object.getString("addressReceiver");
                                String phone_receiver_str = object.getString("phoneReceiver");

                                String weight = object.getString("totalWeight");

                                String cod = object.getString("COD");

                                String spinner_des_str = object.getString("descriptionOrder");
                                String spinner_service_type_str = object.getString("idServiceType");

                                String service_id_type = null;
                                String des = null;

                                name_sender.setText(name_store);
                                address_sender.setText(address_store);
                                phone_sender.setText(phone_store);

                                name_receiver.setText(name_receiver_str);
                                address_receiver.setText(address_receiver_str);
                                phone_receiver.setText(phone_receiver_str);

                                if (cod.equals("1")) {
                                    Log.w("COD WTF", "Add success");
                                    cb_cod.setChecked(true);
                                }

                                Log.w("COD WTF", "Add NO success");
                                Log.w("COD WTF", cod);
                                switch (spinner_des_str) {

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

                                spinner_des.setSelection(Integer.parseInt(des));

                                spinner_service_type.setSelection(Integer.parseInt(spinner_service_type_str));


                            } catch (JSONException e) {
                                e.printStackTrace();
                            }


                        }
                    });

                } else {

                }

            }
        });


    }

}
