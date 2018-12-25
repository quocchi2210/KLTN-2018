package com.example.quocchi.shipper_app;

import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.ContextThemeWrapper;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
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
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;


public class Order_Activity extends AppCompatActivity {

    private ArrayList<Order> data = new ArrayList<Order>();
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
        setContentView(R.layout.activity_order);

        //Log.w("Order token: ",Login_Token.token);

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/showOrder")
                //.url(" http://192.168.0.132:8000/api/shipper/showOrder")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        //Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2x1eGV4cHJlc3MuY2YvYXBpL2xvZ2luIiwiaWF0IjoxNTQ0NDE3OTUwLCJleHAiOjE1NDQ0MzU5NTAsIm5iZiI6MTU0NDQxNzk1MCwianRpIjoidmpmZ0JENTdDUXZLV005NyIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.wTYuIKNs0MDO-dhypmODxDez7Hb_eyMmaWKtO-1CcwE

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if (response.isSuccessful()) {

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
                                    String idOrder = object.getString("idOrder");
                                    String idOrderStatus = object.getString("idOrderStatus");
                                    data.add(new Order(billOfLading, address, idOrder, idOrderStatus));
                                }

                                lv.setAdapter(new OrderAdapter(Order_Activity.this, R.layout.list_item, data));
                                Log.w("Order: ", yourResponse.toString());

                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });
                } else {

                    Log.w("error order", yourResponse.toString());
                }


            }
        });

        Shipper_Position_Send obj = Shipper_Position_Send.getInstance();
        obj.setMyContext(getBaseContext());

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.menu_shipper, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        Intent intent;
        switch(item.getItemId()){
            case R.id.menu_item_history:
                //Toast.makeText(Order_Activity.this, "Ok: History",Toast.LENGTH_SHORT).show();
                intent = new Intent(getBaseContext(), History_Activity.class);
                startActivity(intent);
                break;
            case R.id.menu_item_order:
                intent = new Intent(getBaseContext(), Order_Activity.class);
                startActivity(intent);
                break;
            case R.id.menu_item_order_received:
                intent = new Intent(getBaseContext(), Order_Received_Activity.class);
                startActivity(intent);
                break;
            case R.id.menu_item_search:
                intent = new Intent(getBaseContext(), MapsActivity.class);
                startActivity(intent);
                break;

        }

        return super.onOptionsItemSelected(item);
    }

    private class OrderAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Order> arrayOrder;

        public OrderAdapter(Context context, int layout, List<Order> orderList) {
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
            Log.w("myApp", "Detail: " + data.toString());
            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);

            Button btn_pick_up = (Button) convertView.findViewById(R.id.btn_pick_up);

            bill_of_lading.setText(data.get(position).getBill_of_lading());
            address.setText(data.get(position).getAddress());

            final String id_order = data.get(position).getId_order();

            LinearLayout lnlo_order = (LinearLayout) convertView.findViewById(R.id.lnlo_order);

            final View Testview = convertView;

            final int vitri = position;

            lnlo_order.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", id_order)
                            .build();

                    Request request = new Request.Builder()
                            //.url(" http://192.168.0.132:8000/api/shipper/showDetailOrder")
                            .url("https://luxexpress.cf/api/shipper/showDetailOrder")
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

                                Order_Activity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {
                                            ListView lv_order_detail = new ListView( Order_Activity.this);
                                            ColorDrawable blue = new ColorDrawable(ContextCompat.getColor( Order_Activity.this, R.color.colorBlue));
                                            lv_order_detail.setDivider(blue);
                                            lv_order_detail.setDividerHeight(5);

                                            Log.w("myApp", "BLue : " + blue.toString());

                                            ArrayList<OrderDetail> data_detail = new ArrayList<OrderDetail>();
                                            Jobject = new JSONObject(yourResponse);

                                            String phoneStore = null;
                                            String addressStore = null;
                                            String billOfLading = null;
                                            String nameProduct = null;
                                            String number_of_store = null;
                                            String nameReceiver = null;
                                            String phoneReceiver = null;

                                            JSONArray Jarray = Jobject.getJSONArray("data");

                                            if (Jarray.length() > 0) {

                                                for (int i = 0; i < Jarray.length(); i++) {
                                                    JSONObject object = Jarray.getJSONObject(i);
                                                    Log.w("myApp", "Detail: " + object.toString());

                                                    //String phoneStore = object.getString("phoneStore");
                                                    phoneStore = "123789";
                                                    addressStore = object.getString("addressStore");
                                                    billOfLading = object.getString("billOfLading");
                                                    nameProduct = object.getString("nameProduct");
                                                    //String number_of_store = object.getString("number_of_store");
                                                    number_of_store = "2";
                                                    nameReceiver = object.getString("nameReceiver");
                                                    phoneReceiver = object.getString("phoneReceiver");

                                                    data_detail.add(new OrderDetail(phoneStore, addressStore, billOfLading, nameProduct, number_of_store, nameReceiver,phoneReceiver));
                                                }
                                                lv_order_detail.setAdapter(new OrderDetailAdapter(Order_Activity.this, R.layout.info_order_dialog, data_detail));

//                                                Dialog dialog = new Dialog(Order_Activity.this, R.style.Theme_Dialog);
//                                                dialog.setTitle("Chi tiết đơn hàng");
//                                                dialog.;
                                                //AlertDialog.Builder builder = new AlertDialog.Builder(new ContextThemeWrapper(Order_Activity.this, R.style.Theme_Dialog));

                                                AlertDialog.Builder builder = new AlertDialog.Builder(Order_Activity.this,AlertDialog.THEME_HOLO_LIGHT);
                                                builder.setPositiveButton("OK" ,null);
                                                builder.setView(lv_order_detail);
                                                AlertDialog dialog = builder.create();
                                                dialog.setTitle("Chi tiết đơn hàng");
                                                dialog.show();

                                            } else {
                                                AlertDialog.Builder builder = new AlertDialog.Builder(Order_Activity.this,AlertDialog.THEME_HOLO_LIGHT);
                                                builder.setPositiveButton("OK" ,null);
                                                AlertDialog dialog = builder.create();
                                                dialog.setTitle("Chi tiết đơn hàng");
                                                dialog.setMessage("Không có hóa dơn chi tiết");
                                                dialog.show();
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

                }
            });

            btn_pick_up.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
//                    OkHttpClient client = new OkHttpClient.Builder()
//                            .certificatePinner(certificatePinner)
//                            .build();

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", data.get(vitri).getId_order())
                            .addFormDataPart("status_order_rq", data.get(vitri).getId_order_status())
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

                                Order_Activity.this.runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {

                                            Jobject = new JSONObject(yourResponse);

                                            Log.w("btn_done","Order: " + yourResponse.toString());
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

    private class OrderDetailAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<OrderDetail> arrayOrderDetail;

        public OrderDetailAdapter(Context context, int layout, List<OrderDetail> orderdetailList) {
            myContext = context;
            myLayout = layout;
            arrayOrderDetail = orderdetailList;
        }

        @Override
        public int getCount() {
            return arrayOrderDetail.size();
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

            TextView phone_store = (TextView) convertView.findViewById(R.id.phone_store);
            TextView address_store = (TextView) convertView.findViewById(R.id.address_store);
            TextView bill_of_lading_order_detail = (TextView) convertView.findViewById(R.id.bill_of_lading_order_detail);
            TextView name_product = (TextView) convertView.findViewById(R.id.name_product);
            //TextView number_of_product = (TextView) convertView.findViewById(R.id.number_of_product);

            TextView receiver = (TextView) convertView.findViewById(R.id.receiver);
            TextView phone_receiver = (TextView) convertView.findViewById(R.id.phone_receiver);

            phone_store.setText(arrayOrderDetail.get(position).getPhoneStore());
            address_store.setText(arrayOrderDetail.get(position).getAddressStore());
            bill_of_lading_order_detail.setText(arrayOrderDetail.get(position).getBillOfLading());
            name_product.setText(arrayOrderDetail.get(position).getNameProduct());
            receiver.setText(arrayOrderDetail.get(position).getNameReceiver());
            phone_receiver.setText(arrayOrderDetail.get(position).getPhoneReceiver());
//            dialog.show();
            return convertView;
        }
    }

    private class Order {
        private String bill_of_lading;
        private String address;
        private String id_order;
        private String id_order_status;

        Order(String bill_of_lading, String address, String id_order, String id_order_status) {
            this.bill_of_lading = bill_of_lading;
            this.address = address;
            this.id_order = id_order;
            this.id_order_status = id_order_status;
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

        public String getId_order() {
            return id_order;
        }

        public void setId_order(String id_order) {
            this.id_order = id_order;
        }


        public String getId_order_status() {
            return id_order_status;
        }

        public void setId_order_status(String id_order_status) {
            this.id_order_status = id_order_status;
        }
    }

    private class OrderDetail {

        private String phoneStore;
        private String addressStore;
        private String billOfLading;
        private String nameProduct;
        private String number_of_store;
        private String nameReceiver;
        private String phoneReceiver;

        public OrderDetail(String phoneStore, String addressStore, String billOfLading, String nameProduct, String number_of_store, String nameReceiver, String phoneReceiver) {
            this.phoneStore = phoneStore;
            this.addressStore = addressStore;
            this.billOfLading = billOfLading;
            this.nameProduct = nameProduct;
            this.number_of_store = number_of_store;
            this.nameReceiver = nameReceiver;
            this.phoneReceiver = phoneReceiver;
        }

        public String getPhoneStore() {
            return phoneStore;
        }

        public void setPhoneStore(String phoneStore) {
            this.phoneStore = phoneStore;
        }

        public String getAddressStore() {
            return addressStore;
        }

        public void setAddressStore(String addressStore) {
            this.addressStore = addressStore;
        }

        public String getBillOfLading() {
            return billOfLading;
        }

        public void setBillOfLading(String billOfLading) {
            this.billOfLading = billOfLading;
        }

        public String getNameProduct() {
            return nameProduct;
        }

        public void setNameProduct(String nameProduct) {
            this.nameProduct = nameProduct;
        }

        public String getNumber_of_store() {
            return number_of_store;
        }

        public void setNumber_of_store(String number_of_store) {
            this.number_of_store = number_of_store;
        }

        public String getNameReceiver() {
            return nameReceiver;
        }

        public void setNameReceiver(String nameReceiver) {
            this.nameReceiver = nameReceiver;
        }

        public String getPhoneReceiver() {
            return phoneReceiver;
        }

        public void setPhoneReceiver(String phoneReceiver) {
            this.phoneReceiver = phoneReceiver;
        }

    }
}
