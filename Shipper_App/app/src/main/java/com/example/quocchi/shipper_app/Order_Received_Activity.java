package com.example.quocchi.shipper_app;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;
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

public class Order_Received_Activity extends AppCompatActivity {

    private ArrayList<Order_Received> data = new ArrayList<Order_Received>();
    private String hostname = "luxexpress.cf";
    private String token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2x1eGV4cHJlc3MuY2YvYXBpL2xvZ2luIiwiaWF0IjoxNTQ0NDk2MzA5LCJleHAiOjE1NDQ1MTQzMDksIm5iZiI6MTU0NDQ5NjMwOSwianRpIjoiVTRwUXJuR24yU3VLRndmTyIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.eSY6OvJle766Zzj2zxpRllFb-g4g4ytCxhglipatAjE";

    private CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order_received);

//        ListView list_view_order_received = findViewById(R.id.list_view_order_received);
//
//        data.add(new Order_Received("math","123","09:00:00"));
//        data.add(new Order_Received("history","456","09:00:00"));
//        data.add(new Order_Received("van hoc","789","09:00:00"));
//
//        list_view_order_received.setAdapter(new Order_Received_Adapter(this, R.layout.list_item_order_received, data));

        //OkHttpClient client = new OkHttpClient();

        CertificatePinner certificatePinner = new CertificatePinner.Builder()
                .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
                .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
                .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
                .build();

        OkHttpClient client = new OkHttpClient.Builder()
                .certificatePinner(certificatePinner)
                .build();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                .url("https://luxexpress.cf/api/shipper/showOrderReceived")
                .post(requestBody)
                //.addHeader("name_your_token", "your_token")
                .addHeader("Authorization", "Bearer "+token)
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

                    Order_Received_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {

                                ListView list_view_order_received = findViewById(R.id.list_view_order_received);

                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp","Order received: " + object.toString());
                                    String timeDelivery = object.getString("timeDelivery");
                                    String addressReceiver = object.getString("addressReceiver");
                                    String addressStore = object.getString("addressStore");
                                    String idOrder = object.getString("idOrder");
                                    String idOrderStatus = object.getString("idOrderStatus");

                                    data.add(new Order_Received(addressReceiver,addressStore,timeDelivery,idOrder,idOrderStatus));
                                }

                                list_view_order_received.setAdapter(new Order_Received_Adapter(Order_Received_Activity.this, R.layout.list_item_order_received, data));

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });
                }else{
                    Log.w("myApp","Order received: " + yourResponse.toString());
                }


            }
        });

    }

    private class Order_Received_Adapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order_Received> arrayOrder;

        public Order_Received_Adapter(Context context, int layout, List<Order_Received> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView txt_address_delivery = (TextView) convertView.findViewById(R.id.txt_address_delivery);
            TextView txt_address_receive = (TextView) convertView.findViewById(R.id.txt_address_receive);
            TextView txt_time = (TextView) convertView.findViewById(R.id.txt_time);

            Button btn_see_map = (Button)convertView.findViewById(R.id.btn_see_map);
            Button btn_done = (Button)convertView.findViewById(R.id.btn_done);

            txt_address_delivery.setText(data.get(position).getAddress_delivery());
            txt_address_receive.setText(data.get(position).getAddress_receive());
            txt_time.setText(data.get(position).getTime());

            final int vitri = position;

            btn_see_map.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    Intent intent = new Intent(Order_Received_Activity.this, MapsActivity.class);
                    intent.putExtra("destination_address", data.get(vitri).getAddress_receive());
                    startActivity(intent);

                }
            });

            btn_done.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {

                    OkHttpClient client = new OkHttpClient.Builder()
                            .certificatePinner(certificatePinner)
                            .build();

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", data.get(vitri).getId_order())
                            .addFormDataPart("status_order_rq", data.get(vitri).getStatus_order())
                            .build();

                    Request request = new Request.Builder()
                            //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                            .url("https://luxexpress.cf/api/shipper/updateStatus")
                            .post(requestBody)
                            //.addHeader("name_your_token", "your_token")
                            .addHeader("Authorization", "Bearer "+token)
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

                                Order_Received_Activity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {

                                            Jobject = new JSONObject(yourResponse);

                                            Log.w("btn_done","Order received: " + yourResponse.toString());
                                            finish();
                                            startActivity(getIntent());
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }

                                    }
                                });
                            }else{
                                Log.w("myApp","Order received: " + yourResponse.toString());
                            }


                        }
                    });

                }
            });

            return convertView;
        }
    }

    private class Order_Received{

        private String address_receive;
        private String address_delivery;
        private String time;
        private String id_order;
        private String status_order;

        Order_Received(String address_receive, String address_delivery, String time, String idOrder, String idOrderStatus) {
            this.address_receive = address_receive;
            this.address_delivery = address_delivery;
            this.time = time;
            this.id_order = idOrder;
            this.status_order = idOrderStatus;
        }

        public String getAddress_receive() {
            return address_receive;
        }

        public void setAddress_receive(String address_receive) {
            this.address_receive = address_receive;
        }

        public String getAddress_delivery() {
            return address_delivery;
        }

        public void setAddress_delivery(String address_delivery) {
            this.address_delivery = address_delivery;
        }

        public String getTime() {
            return time;
        }

        public void setTime(String time) {
            this.time = time;
        }

        public String getId_order() {
            return id_order;
        }

        public void setId_order(String id_order) {
            this.id_order = id_order;
        }

        public String getStatus_order() {
            return status_order;
        }

        public void setStatus_order(String status_order) {
            this.status_order = status_order;
        }
    }
}
