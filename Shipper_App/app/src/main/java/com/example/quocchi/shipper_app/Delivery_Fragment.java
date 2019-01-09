package com.example.quocchi.shipper_app;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.TextView;
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

public class Delivery_Fragment extends Fragment {
    private View mRootView;

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

    private TextView phone_store, address_store, bill_of_lading_order, receiver, phone_receiver, address_receiver, time_delivery;

    private Button btn_done;

    private String id_order, id_status;
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.fragment_delivery, container, false);

        mRootView.setVisibility(View.GONE);
        initUI();

        sendpost();

        return mRootView;


    }

    private void initUI(){
        phone_store =(TextView) mRootView.findViewById(R.id.phone_store);
        address_store = (TextView)mRootView.findViewById(R.id.address_store);
        bill_of_lading_order = (TextView)mRootView.findViewById(R.id.bill_of_lading_order);
        phone_receiver =(TextView) mRootView.findViewById(R.id.phone_receiver);
        address_receiver = (TextView)mRootView.findViewById(R.id.address_receiver);
        time_delivery  = (TextView)mRootView.findViewById(R.id.time_delivery);
        receiver = (TextView)mRootView.findViewById(R.id.receiver);

        btn_done  = (Button) mRootView.findViewById(R.id.btn_done);

        btn_done.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                //if(Login_Token.update_check==false) {

                    RequestBody requestBody = new MultipartBody.Builder()
                            .setType(MultipartBody.FORM)
                            .addFormDataPart("id_order", id_order)
                            .addFormDataPart("status_order_rq", id_status)
                            .build();

                    Request request = new Request.Builder()
                            //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                            .url("https://luxexpress.cf/api/shipper/updateStatus")
                            .post(requestBody)
                            //.addHeader("name_your_token", "your_token")
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

                                getActivity().runOnUiThread(new Runnable() {
                                    @Override
                                    public void run() {
                                        JSONObject Jobject = null;
                                        try {

                                            Jobject = new JSONObject(yourResponse);

                                            Log.w("btn_done", "delivery_btn_done " + yourResponse.toString());
                                            getActivity().finish();
                                            startActivity( getActivity().getIntent());

                                        } catch (JSONException e) {
                                            Log.w("btn_done", "delivery_btn_done error" + yourResponse.toString());
                                            e.printStackTrace();
                                        }

                                    }
                                });
                            } else {
                                Log.w("btn_done", "error delivery_btn_done " + yourResponse.toString());
                            }


                        }
                    });
//                }else{
//                    //Toast.makeText(getActivity(), "Bạn cần giao hàng trước.", Toast.LENGTH_SHORT).show();
//                }

            }
        });
    }

    private void sendpost(){
        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.0.132:8000/api/shipper/showOrderReceived")
                .url("https://luxexpress.cf/api/shipper/checkOrderShipper")
                .post(requestBody)
                //.addHeader("name_your_token", "your_token")
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
                    if(getActivity() != null) {
                        getActivity().runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                JSONObject Jobject = null;
                                try {

                                    Jobject = new JSONObject(yourResponse);
                                    String Jarray_data = Jobject.getString("data");

                                    if (Integer.parseInt(Jarray_data) > 0) {

                                        JSONArray Jarray = Jobject.getJSONArray("data_order");
                                        JSONObject object = Jarray.getJSONObject(0);
                                        Log.w("delivery", "delivery: " + object.toString());
                                        String timeDelivery = object.getString("timeDelivery");
                                        String addressReceiver = object.getString("addressReceiver");
                                        String addressStore = object.getString("addressStore");

                                        String billOfLading_str = object.getString("billOfLading");
                                        String total_money_str = object.getString("totalMoney");
                                        String name_received_str = object.getString("nameReceiver");
                                        String phone_received_str = object.getString("phoneReceiver");
                                        String phone_store_str = object.getString("phoneNumber");

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

                                        id_order = object.getString("idOrder");
                                        id_status = object.getString("idOrderStatus");

                                        Log.w("deliveryfragment", yourResponse.toString());

                                        mRootView.setVisibility(View.VISIBLE);
                                    } else {
                                        Log.w("deliveryfragment error", yourResponse.toString());
                                        mRootView.setVisibility(View.GONE);
                                        //Toast.makeText(getActivity(), "Hiện tại không có đơn hàng nào: ",Toast.LENGTH_SHORT).show();
                                    }
                                    //phone_store, address_store, bill_of_lading_order, receiver, phone_receiver, address_receiver

                                } catch (JSONException e) {
                                    Log.w("error deliveryfragment", yourResponse.toString());
                                    e.printStackTrace();
                                }

                            }
                        });
                    }
                } else {
                    Log.w("myApp", "ERROR Order received: " + yourResponse.toString());
                }


            }
        });
    }
}
