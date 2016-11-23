namespace php Services.AuctionService
namespace java Services.AuctionService

exception InvalidException {
		1: i32 code
    2: string message
}

struct Scene {
  1: i64 orderId,
  2: i64 sceneId,
  3: string biddingStartTime,
  4: string biddingEndTime,
  5: i64 estElapsedTime,
  6: i64 actElapsedTime,
  7: bool isTimingOrder
}

service AuctionService{
	// 竞标出价
	bool bidding(1:i64 dealerId, 2:i64 orderId, 3:double price) throws (1:InvalidException ex),

	// 投标出价
	bool bid(1:i64 dealerId, 2:i64 orderId, 3:double price) throws (1:InvalidException ex),

	//上拍
	bool startAuction(1:Scene scenne) throws (1:InvalidException ex)

}
