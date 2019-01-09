package com.example.quocchi.shipper_app;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
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

public class Search_Activity extends AppCompatActivity {

    private TextView phone_store, address_store, bill_of_lading_order, receiver, phone_receiver, address_receiver, time_delivery;

    private String hostname = "luxexpress.cf";
    private String token = Login_Token.token;

    private CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    private OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        initUI();

        send_post();
    }

    private void initUI() {
        phone_store = (TextView) findViewById(R.id.phone_store);
        address_store = (TextView) findViewById(R.id.address_store);
        bill_of_lading_order = (TextView) findViewById(R.id.bill_of_lading_order);
        phone_receiver = (TextView) findViewById(R.id.phone_receiver);
        address_receiver = (TextView) findViewById(R.id.address_receiver);
        time_delivery = (TextView) findViewById(R.id.time_delivery);
        receiver = (TextView) findViewById(R.id.receiver);

    }

    private void send_post(){


        Intent intent = getIntent();
        final String search_text = intent.getStringExtra("search_text");
        Log.w("abcffff", search_text);

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("bill_of_lading", search_text)
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/searchBilloflading")
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
                Log.w("searchsend: ", yourResponse.toString());
                if (response.isSuccessful()) {
                    Search_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            Log.w("searchsend true", yourResponse.toString());
                            try {
                                Jobject = new JSONObject(yourResponse);
                                JSONObject Jarray = Jobject.getJSONObject("data");

                                String timeDelivery = Jarray.getString("timeDelivery");
                                String addressReceiver = Jarray.getString("addressReceiver");
                                String addressStore = Jarray.getString("addressStore");

                                String billOfLading_str = Jarray.getString("billOfLading");
                                String total_money_str = Jarray.getString("totalMoney");
                                String name_received_str = Jarray.getString("nameReceiver");
                                String phone_received_str = Jarray.getString("phoneReceiver");
                                String phone_store_str = Jarray.getString("phoneNumber");

                                if(timeDelivery.equals("null")){
                                    timeDelivery = "";
                                }
                                if(addressReceiver.equals("null")){
                                    addressReceiver = "";
                                }
                                if(addressStore.equals("null")){
                                    addressStore = "";
                                }
                                if(billOfLading_str.equals("null")){
                                    billOfLading_str = "";
                                }
                                if(total_money_str.equals("null")){
                                    total_money_str = "";
                                }
                                if(name_received_str.equals("null")){
                                    name_received_str = "";
                                }
                                if(phone_received_str.equals("null")){
                                    phone_received_str = "";
                                }
                                if(phone_store_str.equals("null")){
                                    phone_store_str = "";
                                }

                                phone_store.setText(phone_store_str);
                                address_store.setText(addressStore);
                                bill_of_lading_order.setText(billOfLading_str);
                                receiver.setText(name_received_str);
                                phone_receiver.setText(phone_received_str);
                                address_receiver.setText(addressReceiver);
                                time_delivery.setText(timeDelivery);

                               //Log.w("abcffff", billOfLading_str);

                            } catch (JSONException e) {
                                Log.w("searchsend false", e.toString());
                                e.printStackTrace();

                            }

                        }
                    });

                } else {
                    Log.w("searchsend error", yourResponse.toString());
                }

            }
        });
    }
}
