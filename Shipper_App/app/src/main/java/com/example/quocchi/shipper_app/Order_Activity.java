package com.example.quocchi.shipper_app;

import android.app.Dialog;
import android.content.Context;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
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
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Order_Activity extends AppCompatActivity {

    private ArrayList<Order> data = new ArrayList<Order>();
    //public int position_index = -1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order);

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

                    Order_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {
                                ListView lv = findViewById(R.id.list_view);
                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");


                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp", object.toString());
                                    String billOfLading = object.getString("billOfLading");
                                    String address = object.getString("addressReceiver");
                                    data.add(new Order(billOfLading,address));
                                }

                                lv.setAdapter(new OrderAdapter(Order_Activity.this, R.layout.list_item, data));

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });
                }else{

                }


            }
        });

    }

    private class OrderAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order> arrayOrder;

        public OrderAdapter(Context context, int layout, List<Order> orderList){
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

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);

            bill_of_lading.setText(data.get(position).getBill_of_lading());
            address.setText(data.get(position).getAddress());

            LinearLayout lnlo_order = (LinearLayout) convertView.findViewById (R.id.lnlo_order);

            final int vitri = position;

            lnlo_order.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    OkHttpClient client = new OkHttpClient();

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", "1")
                            .build();

                    Request request = new Request.Builder()
                            //.url("http://192.168.1.16:8000/api/shipper/showOrder")
                            .url(" http://192.168.0.132:8000/api/shipper/showDetailOrder")
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

                                Order_Activity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {
                                            ListView lv = findViewById(R.id.list_view);
                                            Jobject = new JSONObject(yourResponse);

                                            JSONArray Jarray = Jobject.getJSONArray("data");


                                            for (int i = 0; i < Jarray.length(); i++) {
                                                JSONObject object = Jarray.getJSONObject(i);
                                                Log.w("myApp", "Detail: "+object.toString());
                                                //Toast.makeText(Order_Activity.this, object.toString(), Toast.LENGTH_LONG).show();

                                                //Toast.makeText(Order_Activity.this, data.get(vitri).getBill_of_lading(), Toast.LENGTH_LONG).show();
                                                Dialog dialog = new Dialog(Order_Activity.this,R.style.Theme_Dialog);
                                                dialog.setTitle("TEST");
                                                dialog.setContentView(R.layout.info_order_dialog);

                                                //TextView phone_store = (TextView) dialog.findViewById(R.id.phone_store);
                                                TextView address_store = (TextView) dialog.findViewById(R.id.address_store);
                                                TextView bill_of_lading_order_detail = (TextView) dialog.findViewById(R.id.bill_of_lading_order_detail);
                                                TextView name_product = (TextView) dialog.findViewById(R.id.name_product);
                                                //TextView number_of_product = (TextView) dialog.findViewById(R.id.number_of_product);
                                                TextView receiver = (TextView) dialog.findViewById(R.id.receiver);
                                                TextView phone_receiver = (TextView) dialog.findViewById(R.id.phone_receiver);


                                                //phone_store.setText("Điện thoại: " + object.getString("phoneStore"));
                                                address_store.setText("Địa chỉ: " + object.getString("addressStore"));
                                                bill_of_lading_order_detail.setText("Mã đơn hàng: " + object.getString("billOfLading"));
                                                name_product.setText("Tên sản phẩm: " + object.getString("nameProduct"));
                                                //number_of_product.setText("Số lượng: " + object.getString("number_of_store"));
                                                receiver.setText("Người nhận: " + object.getString("nameReceiver"));
                                                phone_receiver.setText("Số điện thoại: " + object.getString("phoneReceiver"));

                                                dialog.show();
                                            }


                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                        }

                                    }
                                });
                            }else{

                            }


                        }
                    });

                }
            });

            return convertView;
        }
    }


    private class Order{
        private String bill_of_lading;
        private String address;

        Order(String bill_of_lading, String address){
            this.bill_of_lading = bill_of_lading;
            this.address = address;
        }

        public String getBill_of_lading() {
            return bill_of_lading;
        }

        public void setBill_of_lading(String bill_of_lading) {
            this.bill_of_lading = bill_of_lading;
        }

        public String getAddress() {
            return address;
        }

        public void setAddress(String address) {
            this.address = address;
        }
    }
}
